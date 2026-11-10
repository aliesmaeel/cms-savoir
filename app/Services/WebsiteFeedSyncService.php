<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Community;
use App\Models\NewProperty;
use App\Models\SubCommunity;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Throwable;

class WebsiteFeedSyncService
{
    /**
     * Match the website feed to new_properties by reference number.
     * Existing rows are updated, missing feed rows are inserted, and database
     * rows whose reference is not in the feed are deleted.
     *
     * @return array<string, mixed>
     */
    public function sync(): array
    {
        $lock = Cache::lock('website-feed-sync', 900);

        if (!$lock->get()) {
            return [
                'skipped' => true,
                'message' => 'A website feed sync is already running.',
            ];
        }

        try {
            return $this->syncUnlocked();
        } finally {
            $lock->release();
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function syncUnlocked(): array
    {
        $properties = $this->fetchFeed();

        $communities = Community::query()->pluck('id', 'name');
        $subCommunities = SubCommunity::query()->pluck('id', 'name');
        $usersByEmail = [];
        foreach (User::query()->get(['id', 'email']) as $user) {
            $usersByEmail[strtolower((string) $user->email)] = (int) $user->id;
        }

        $summary = [
            'skipped' => false,
            'total' => count($properties),
            'created' => 0,
            'updated' => 0,
            'unchanged' => 0,
            'images_updated' => 0,
            'deleted' => 0,
            'failed' => 0,
            'sub_communities_created' => 0,
            'unmatched_communities' => [],
            'unmatched_sub_communities' => [],
            'unmatched_agents' => [],
        ];

        $references = [];
        $unmatchedCommunities = [];
        $unmatchedSubCommunities = [];
        $unmatchedAgents = [];

        NewProperty::withoutSyncingToSearch(function () use (
            $properties,
            $communities,
            $subCommunities,
            $usersByEmail,
            &$summary,
            &$references,
            &$unmatchedCommunities,
            &$unmatchedSubCommunities,
            &$unmatchedAgents
        ): void {
            DB::transaction(function () use (
                $properties,
                $communities,
                $subCommunities,
                $usersByEmail,
                &$summary,
                &$references,
                &$unmatchedCommunities,
                &$unmatchedSubCommunities,
                &$unmatchedAgents
            ): void {
                foreach ($properties as $property) {
                    if (!is_array($property)) {
                        $summary['failed']++;
                        continue;
                    }

                    $reference = trim((string) ($property['ref_number'] ?? ''));
                    if ($reference === '') {
                        $summary['failed']++;
                        continue;
                    }

                    $references[] = $reference;

                    try {
                        $result = $this->upsert(
                            $property,
                            $reference,
                            $communities,
                            $subCommunities,
                            $usersByEmail,
                            $unmatchedCommunities,
                            $unmatchedSubCommunities,
                            $unmatchedAgents
                        );
                        $summary[$result['action']]++;
                        if ($result['images_updated']) {
                            $summary['images_updated']++;
                        }
                        $summary['sub_communities_created'] += $result['sub_community_created'];
                    } catch (Throwable $exception) {
                        $summary['failed']++;
                        Log::error('Website feed listing failed', [
                            'reference' => $reference,
                            'error' => $exception->getMessage(),
                        ]);
                    }
                }

                $imported = $summary['created'] + $summary['updated'] + $summary['unchanged'];
                if ($imported === 0) {
                    throw new RuntimeException('No listings were imported. The database was left unchanged.');
                }

                $summary['deleted'] = $this->deleteMissing(array_values(array_unique($references)));
            });
        });

        $summary['unmatched_communities'] = array_keys($unmatchedCommunities);
        $summary['unmatched_sub_communities'] = array_keys($unmatchedSubCommunities);
        $summary['unmatched_agents'] = array_keys($unmatchedAgents);

        Log::info('Website feed sync finished', $summary);

        return $summary;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchFeed(): array
    {
        $url = (string) config('services.website_feed.url');
        if ($url === '') {
            throw new RuntimeException('WEBSITE_FEED_URL is not set.');
        }

        $response = Http::acceptJson()->timeout(90)->get($url);
        if (!$response->successful()) {
            throw new RuntimeException('Website feed request failed with status ' . $response->status() . '.');
        }

        $properties = $response->json();
        if (!is_array($properties) || !array_is_list($properties)) {
            throw new RuntimeException('Website feed did not return a list of properties.');
        }

        if ($properties === []) {
            throw new RuntimeException('Website feed was empty. No listings were changed.');
        }

        return $properties;
    }

    /**
     * @param array<string, mixed> $property
     * @param \Illuminate\Support\Collection<string, mixed> $communities
     * @param \Illuminate\Support\Collection<string, mixed> $subCommunities
     * @param array<string, int> $usersByEmail
     * @param array<string, bool> $unmatchedCommunities
     * @param array<string, bool> $unmatchedSubCommunities
     * @param array<string, bool> $unmatchedAgents
     * @return array{action: string, images_updated: bool, sub_community_created: int}
     */
    private function upsert(
        array $property,
        string $reference,
        $communities,
        $subCommunities,
        array $usersByEmail,
        array &$unmatchedCommunities,
        array &$unmatchedSubCommunities,
        array &$unmatchedAgents
    ): array {
        $communityName = trim((string) data_get($property, 'community.name', ''));
        $communityId = $communityName !== '' ? $communities->get($communityName) : null;
        if ($communityName !== '' && $communityId === null) {
            $unmatchedCommunities[$communityName] = true;
        }

        $subCommunityName = trim((string) data_get($property, 'sub_community.name', ''));
        $resolvedSubCommunity = $this->resolveSubCommunity(
            $subCommunityName,
            $communityId,
            $subCommunities,
            $unmatchedSubCommunities
        );
        $subCommunityId = $resolvedSubCommunity['id'];

        $email = strtolower(trim((string) data_get($property, 'agent.email', '')));
        $userId = $email !== '' ? ($usersByEmail[$email] ?? null) : null;
        if ($email !== '' && $userId === null) {
            $unmatchedAgents[$email] = true;
        }

        $imageUrls = $this->imageUrls($property);
        $codes = $this->featureCodes($property);

        $attributes = [
            'reference_number' => $reference,
            'offering_type' => $this->offeringType($property),
            'property_type' => (string) data_get($property, 'property_category.pf_code', ''),
            'price' => (int) ($property['price'] ?? 0),
            'title_en' => (string) ($property['title'] ?? ''),
            'description_en' => (string) ($property['description'] ?? ''),
            'size' => (int) ($property['bua'] ?? 0),
            'bedroom' => $this->roomCount(data_get($property, 'beds.name')),
            'bathroom' => $this->roomCount(data_get($property, 'baths.name')),
            'community' => $communityId,
            'sub_community' => $subCommunityId,
            'private_amenities' => implode(',', $codes),
            'features' => $codes,
            'user_id' => $userId ?? 1,
            'city' => trim((string) data_get($property, 'region.name', '')),
            'featured' => (int) ($property['featured'] ?? 0),
            'completion_status' => data_get($property, 'completion_status') === 'Off plan' ? 'off_plan' : 'completed',
            'lat' => $this->coordinate($property['latitude'] ?? null),
            'lng' => $this->coordinate($property['longitude'] ?? null),
            'photo' => $imageUrls[0] ?? null,
            'currency' => 'AED',
            'country' => 'United Arab Emirates',
        ];

        $existing = NewProperty::query()->where('reference_number', $reference)->get();
        $imagesUpdated = false;

        if ($existing->isEmpty()) {
            $propertyModel = new NewProperty();
            $propertyModel->forceFill($attributes + [
                'permit_number' => '_',
                'property_status' => 'Live',
                'slug' => $this->makeSlug((string) $attributes['title_en']),
                'finder' => 1,
                'bayut' => 1,
                'dubizzle' => 1,
                'emirates_estate' => 0,
            ]);
            $propertyModel->save();
            $this->replaceImages($propertyModel, $imageUrls);

            return [
                'action' => 'created',
                'images_updated' => $imageUrls !== [],
                'sub_community_created' => $resolvedSubCommunity['created'],
            ];
        }

        $changed = false;
        foreach ($existing as $propertyModel) {
            $dirty = false;
            foreach ($attributes as $key => $value) {
                if ($this->differs($propertyModel->getAttribute($key), $value)) {
                    $dirty = true;
                    break;
                }
            }

            if ($dirty) {
                $propertyModel->fill($attributes);
                $propertyModel->save();
                $changed = true;
            }

            if ($this->replaceImages($propertyModel, $imageUrls)) {
                $imagesUpdated = true;
                $changed = true;
                if (!$dirty) {
                    $propertyModel->touch();
                }
            }
        }

        return [
            'action' => $changed ? 'updated' : 'unchanged',
            'images_updated' => $imagesUpdated,
            'sub_community_created' => $resolvedSubCommunity['created'],
        ];
    }

    /**
     * Use an existing sub-community or create it under the listing's community.
     *
     * @param \Illuminate\Support\Collection<string, mixed> $subCommunities
     * @param array<string, bool> $unmatchedSubCommunities
     * @return array{id: int|null, created: int}
     */
    private function resolveSubCommunity(
        string $name,
        mixed $communityId,
        $subCommunities,
        array &$unmatchedSubCommunities
    ): array {
        if ($name === '') {
            return ['id' => null, 'created' => 0];
        }

        $existingId = $subCommunities->get($name);
        if ($existingId !== null) {
            return ['id' => (int) $existingId, 'created' => 0];
        }

        if ($communityId === null) {
            $unmatchedSubCommunities[$name] = true;

            return ['id' => null, 'created' => 0];
        }

        $subCommunity = SubCommunity::query()->create([
            'name' => $name,
            'community_id' => $communityId,
        ]);
        $subCommunities->put($name, $subCommunity->id);

        Log::info('Website feed created sub-community', [
            'name' => $name,
            'community_id' => $communityId,
        ]);

        return ['id' => (int) $subCommunity->id, 'created' => 1];
    }

    /**
     * @param array<int, string> $references
     */
    private function deleteMissing(array $references): int
    {
        $ids = NewProperty::query()
            ->where(function ($query) use ($references): void {
                $query->whereNotIn('reference_number', $references)
                    ->orWhereNull('reference_number')
                    ->orWhere('reference_number', '');
            })
            ->pluck('id');

        if ($ids->isEmpty()) {
            return 0;
        }

        foreach ([
            'property_images',
            'property_videos',
            'property_floor_plans',
            'bayut_properties',
            'dubizzle_properties',
            'finder_properties',
            'emirates_properties',
        ] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'newProperty_id')) {
                DB::table($table)->whereIn('newProperty_id', $ids)->delete();
            }
        }

        if (Schema::hasTable('off_plan_projects') && Schema::hasColumn('off_plan_projects', 'property_id')) {
            DB::table('off_plan_projects')->whereIn('property_id', $ids)->delete();
        }

        return NewProperty::query()->whereIn('id', $ids)->delete();
    }

    /**
     * Replace the gallery when the feed list differs, including when new photos were added.
     *
     * @param array<int, string> $imageUrls
     */
    private function replaceImages(NewProperty $property, array $imageUrls): bool
    {
        $current = DB::table('property_images')
            ->where('newProperty_id', $property->id)
            ->orderBy('id')
            ->pluck('url')
            ->map(static fn ($url): string => (string) $url)
            ->all();

        if ($current === $imageUrls) {
            return false;
        }

        DB::table('property_images')->where('newProperty_id', $property->id)->delete();

        $now = now();
        $rows = [];
        foreach ($imageUrls as $url) {
            $rows[] = [
                'url' => $url,
                'newProperty_id' => $property->id,
                'is_external_image' => str_starts_with($url, 'http://') || str_starts_with($url, 'https://'),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('property_images')->insert($chunk);
        }

        return true;
    }

    /**
     * @param array<string, mixed> $property
     * @return array<int, string>
     */
    private function imageUrls(array $property): array
    {
        $urls = [];
        foreach ($property['photos'] ?? [] as $photo) {
            $name = trim((string) (is_array($photo) ? ($photo['name'] ?? '') : ''));
            if ($name !== '') {
                $urls[] = $name;
            }
        }

        return $urls;
    }

    /**
     * @param array<string, mixed> $property
     * @return array<int, string>
     */
    private function featureCodes(array $property): array
    {
        $codes = [];
        foreach ($property['features'] ?? [] as $feature) {
            $code = trim((string) (is_array($feature) ? ($feature['pf_code'] ?? '') : ''));
            if ($code !== '') {
                $codes[] = $code;
            }
        }

        return $codes;
    }

    /**
     * @param array<string, mixed> $property
     */
    private function offeringType(array $property): string
    {
        $offering = strtoupper(trim((string) ($property['offering_type'] ?? '')));
        if (in_array($offering, ['RS', 'RR', 'RC', 'CR', 'CS'], true)) {
            return $offering;
        }

        return ($property['for'] ?? null) === 1 ? 'RS' : 'RR';
    }

    private function roomCount(mixed $name): int
    {
        if (!is_string($name) || trim($name) === '') {
            return 0;
        }

        $first = explode(' ', trim($name))[0];
        if (strcasecmp($first, 'studio') === 0) {
            return 0;
        }

        return (int) $first;
    }

    private function coordinate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (string) $value;
    }

    private function differs(mixed $current, mixed $next): bool
    {
        if (is_array($current) || is_array($next)) {
            return json_encode(array_values((array) $current)) !== json_encode(array_values((array) $next));
        }

        return (string) ($current ?? '') !== (string) ($next ?? '');
    }

    private function makeSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = str_replace(['|', '/', '%'], ['', '-', '-'], $slug);
        $slug = preg_replace('/\s+/', ' ', $slug) ?? $slug;
        $slug = str_replace(' ', '-', trim($slug));
        $slug = trim($slug, '-');

        if ($slug === '') {
            $slug = 'property';
        }

        $candidate = $slug;
        $suffix = 2;
        while (NewProperty::query()->where('slug', $candidate)->exists()) {
            $candidate = $slug . '-' . $suffix;
            $suffix++;
        }

        return $candidate;
    }
}
