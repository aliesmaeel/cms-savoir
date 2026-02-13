<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\NewProperty;

class PropertySearchService
{
    /**
     * Search properties for the chat (OpenAI tool). Maps tool args to Meilisearch filters
     * and returns properties in the chat response format.
     *
     * @param array<string, mixed> $args Keys: propertyType, bedrooms, location, minPrice, maxPrice, status, purpose, sortBy, limit
     * @return array<int, array<string, mixed>>
     */
    public function searchForChat(array $args): array
    {
        $query = is_string($args['location'] ?? null) ? trim($args['location']) : '';
        $limit = min(20, max(1, (int) ($args['limit'] ?? 5)));
        $offset = 0;

        $sortFieldInput = (string) ($args['sortBy'] ?? 'date');
        $allowedSorts = [
            'name'  => 'title_en',
            'date'  => 'updated_at',
            'price' => 'price',
        ];
        $sortField = $allowedSorts[$sortFieldInput] ?? 'updated_at';
        $sortOrder = 'desc';

        $filterConditions = [];

        $propertyType = $args['propertyType'] ?? null;
        if (is_string($propertyType) && $propertyType !== '') {
            $filterConditions[] = 'property_type = "' . addslashes($propertyType) . '"';
        }

        $bedrooms = $args['bedrooms'] ?? null;
        if (is_numeric($bedrooms)) {
            $filterConditions[] = 'bedroom = ' . (int) $bedrooms;
        }

        $minPrice = $args['minPrice'] ?? null;
        $maxPrice = $args['maxPrice'] ?? null;
        if (is_numeric($minPrice) && is_numeric($maxPrice)) {
            $filterConditions[] = 'price >= ' . (float) $minPrice . ' AND price <= ' . (float) $maxPrice;
        } elseif (is_numeric($minPrice)) {
            $filterConditions[] = 'price >= ' . (float) $minPrice;
        } elseif (is_numeric($maxPrice)) {
            $filterConditions[] = 'price <= ' . (float) $maxPrice;
        }

        $status = $args['status'] ?? null;
        if (is_string($status) && $status !== '') {
            $completionStatus = $status === 'ready' ? 'completed' : 'off_plan';
            $filterConditions[] = 'completion_status = "' . $completionStatus . '"';
        }

        $purpose = $args['purpose'] ?? null;
        if (is_string($purpose) && $purpose !== '') {
            $offeringType = $purpose === 'rent' ? 'RR' : 'RS';
            $filterConditions[] = 'offering_type = "' . $offeringType . '"';
        }

        $filterString = implode(' AND ', $filterConditions);

        $raw = NewProperty::search($query, function ($meilisearch, $q, $options) use (
            $filterString,
            $limit,
            $offset,
            $sortField,
            $sortOrder
        ) {
            if ($filterString !== '') {
                $options['filter'] = $filterString;
            }
            $options['limit'] = $limit;
            $options['offset'] = $offset;
            $options['sort'] = [$sortField . ':' . $sortOrder];

            return $meilisearch->search($q, $options);
        })->raw();

        $hits = $raw['hits'] ?? [];
        $ids = array_column($hits, 'id');

        if (empty($ids)) {
            return [];
        }

        $properties = NewProperty::whereIn('id', $ids)
            ->with(['pcommunity:id,name', 'psubcommunity:id,name'])
            ->get()
            ->sortBy(fn($item) => array_search($item->id, $ids))
            ->values();

        $baseUrl = rtrim(config('services.cms_link', config('app.url')), '/');

        return $properties->map(function ($item) use ($baseUrl) {
            $location = array_filter([
                $item->pcommunity?->name,
                $item->psubcommunity?->name,
                $item->city,
            ]);
            $locationStr = implode(', ', $location);

            return [
                'id'         => (string) $item->id,
                'title'      => $item->title_en ?? '',
                'location'   => $locationStr,
                'price'      => $item->currency === 'AED' ? 'AED ' . number_format((float) $item->price) : (string) $item->price,
                'bedrooms'   => (int) $item->bedroom,
                'bathrooms'  => (int) $item->bathroom,
                'size'       => (int) ($item->size ?? 0),
                'developer'  => $item->project_name ?? '',
                'status'     => $item->completion_status === 'completed' ? 'Ready' : 'Off-plan',
                'roi'        => '',
                'image'      => $item->photo ?? '',
                'link'       => $baseUrl . '/property/' . ($item->slug ?? $item->id),
            ];
        })->all();
    }
}
