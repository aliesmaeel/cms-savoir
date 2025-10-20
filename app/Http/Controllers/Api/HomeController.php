<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\Email;
use App\Models\Insight;
use App\Models\ListingSyndication;
use App\Models\MarketingChannels;
use App\Models\NewProperty;
use App\Models\OffPlanProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class HomeController
{
    public function homePage()
    {
        // ✅ Get all countries (distinct names)
        $countries = DB::table('countries')
            ->select('name', 'image')
            ->distinct()
            ->get();

        $search = [];

        foreach ($countries as $country) {
            // ✅ Get all communities in this country
            $communities = DB::table('communities')
                ->whereIn('id', function ($query) use ($country) {
                    $query->select('community')
                        ->from('new_properties')
                        ->where('country', $country->name);
                })
                ->get();

            $formattedCommunities = [];

            foreach ($communities as $community) {
                $subCommunities = DB::table('sub_communities')
                    ->where('community_id', $community->id)
                    ->get(['id', 'name']);

                $formattedCommunities[] = [
                    'id' => $community->id,
                    'name' => $community->name,
                    'sub_communities' => $subCommunities,
                ];
            }

            $search[] = [
                'country' => $country->name,
                'communities' => $formattedCommunities,
            ];
        }

        // ✅ Fetch featured properties from Meilisearch
        // You can safely chain .whereIn() after search() in Scout
        $properties = NewProperty::search('featured:true')
            ->whereIn('completion_status', ['off_plan', 'completed'])
            ->whereIn('offering_type', ['RR', 'RS'])
            ->take(9)
            ->get([
                'id', 'offering_type', 'price', 'slug',
                'bedroom', 'bathroom', 'size', 'parking',
                'photo', 'completion_status'
            ]);

        // ✅ Group properties by type
        $grouped = [
            'off_plan' => $properties
                ->where('completion_status', 'off_plan')
                ->take(3)
                ->values(),
            'RR' => $properties
                ->where('completion_status', 'completed')
                ->where('offering_type', 'RR')
                ->take(3)
                ->values(),
            'RS' => $properties
                ->where('completion_status', 'completed')
                ->where('offering_type', 'RS')
                ->take(3)
                ->values(),
        ];

        // ✅ Fetch other homepage data
        $insights = DB::table('insights')
            ->select('id', 'title', 'slug', 'image', 'title_details')
            ->take(4)
            ->get();

        $areas = DB::table('communities')
            ->orderBy('order', 'asc')
            ->select('name', 'image')
            ->take(6)
            ->get();

        $testimonials = DB::table('testimonials')
            ->select('id', 'name', 'position', 'image', 'message')
            ->get();

        $offplan_projects = OffPlanProject::select('id', 'image', 'link')
            ->orderBy('order', 'asc')
            ->take(5)
            ->get();

        $marketChannels = MarketingChannels::select('id', 'image')->get();
        $listingSyndication = ListingSyndication::select('id', 'image')->get();

        // ✅ Cache for 10 minutes
        return Cache::remember('homepage_data', now()->addMinutes(10), function () use (
            $search, $grouped, $countries, $insights, $areas,
            $testimonials, $offplan_projects, $marketChannels, $listingSyndication
        ) {
            return [
                'search' => $search,
                'featured_properties' => $grouped,
                'countries' => $countries,
                'insights' => $insights,
                'areas' => $areas,
                'testimonials' => $testimonials,
                'offplan_projects' => $offplan_projects,
                'marketChannels' => $marketChannels,
                'listingSyndications' => $listingSyndication,
            ];
        });
    }

    public function news()
    {
        $news = Insight::
            select('id', 'title', 'slug', 'image','created_at')
            ->paginate(6);

        return response()->json($news);
    }

    public function newsDetails($slug)
    {

        $newsItem = Insight::where('slug', $slug)
            ->first();

        $suggestedNews =Insight::
            where('slug', '!=', $slug)
            ->select('id', 'title', 'slug', 'image','created_at')
            ->take(5)
            ->get();

        if (!$newsItem) {
            return response()->json(['message' => 'News item not found'], 404);
        }

        return response()->json([
            'news_item' => $newsItem,
            'suggested_news' => $suggestedNews,
        ]);
    }
    public function updateShares($id){
        $insight = Insight::find($id);
        if (!$insight) {
            return response()->json(['message' => 'Insight not found'], 404);
        }
        $insight->shares = $insight->shares + 1;
        $insight->save();
        return response()->json(['message' => 'Shares updated successfully', 'shares' => $insight->shares]);
    }
    public function blogs()
    {
        $blogs = Blog::with('blog_image')
            ->select('id', 'title', 'slug','created_at', 'posted_by', 'title_details')
            ->paginate(9);

        return response()->json($blogs);
    }

    public function blogDetails($slug)
    {
        $blog = Blog::with('blog_image')
            ->where('slug', $slug)
            ->first();

        $suggestedBlogs = Blog::with('blog_image')
            ->where('slug', '!=', $slug)
            ->select('id', 'title', 'slug','date', 'posted_by', 'title_details')
            ->take(5)
            ->get();

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json([
            'blog' => $blog,
            'suggested_blogs' => $suggestedBlogs,
        ]);
    }
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $subscription = DB::table('subscriptions')->insert([
            'email' => $request->email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json(['message' => 'Subscribed successfully']);
    }

    public function downloadBrochure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::table('downloaded_brochures')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'brochure_name' => $request->brochure_name,
        ]);
        //lest assume brochure exists in public/brochures/ i want to return it as download
        $brochurePath = public_path('/storage/realestatepdf/' . $request->brochure_name);

        if (file_exists($brochurePath)) {
            return response()->download($brochurePath);
        } else {
            return response()->json(['message' => 'Brochure not found'], 404);
        }

    }

    public function talkToExpert(Request $request)
    {
        return $this->handleContactRequest($request, 'talk_to_expert');
    }

    public function contactUs(Request $request)
    {
        return $this->handleContactRequest($request, 'contact_us');
    }

    private function handleContactRequest(Request $request, string $type)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::table('emails')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'type' => $type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Your request has been submitted successfully. Our team will contact you soon.'
        ]);
    }


    public function search(Request $request)
    {
        $queryInput = $request->input('query', '');
        $query = is_array($queryInput) ? implode(' ', $queryInput) : $queryInput;
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 10);

        $sortField = $request->input('sort_field', 'updated_at');
        $sortOrder = $request->input('sort_order', 'desc');

        // Pagination offset
        $offset = ($page - 1) * $perPage;

        // Build filter string dynamically
        $filters = [];
        if ($request->filled('interested_in')) {
            $filters[] = 'offering_type = "' . $request->interested_in . '"';
        }
        if ($request->filled('compleation_status')) {
            $filters[] = 'completion_status = "' . $request->compleation_status . '"';
        }
        if ($request->filled('type')) {
            $filters[] = 'property_type = "' . $request->type . '"';
        }
        if ($request->filled('bedroom')) {
            $filters[] = 'bedrooms = ' . (int) $request->bedroom;
        }

        $filterString = count($filters) ? implode(' AND ', $filters) : null;

        // Run the Meilisearch query via raw() to keep correct sorting order
        $rawResult = NewProperty::search($query, function ($meilisearch, $q, $options) use ($filterString, $sortField, $sortOrder, $perPage, $offset) {
            if ($filterString) {
                $options['filter'] = $filterString;
            }

            $options['limit'] = $perPage;
            $options['offset'] = $offset;
            $options['sort'] = [$sortField . ':' . $sortOrder];

            return $meilisearch->search($q, $options);
        })->raw();

        // Extract IDs in correct order
        $ids = collect($rawResult['hits'])->pluck('id')->toArray();

        // Get Eloquent models preserving the same order
        $properties = NewProperty::whereIn('id', $ids)
            ->with(['pcommunity:id,name', 'psubcommunity:id,name', 'user:id,name,email,phone,image'])
            ->get()
            ->sortBy(fn($model) => array_search($model->id, $ids))
            ->values();

        // Transform the data
        $transformed = $properties->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title_en,
                'price' => $item->price,
                'bedrooms' => $item->bedrooms,
                'bathrooms' => $item->bathrooms,
                'community' => optional($item->pcommunity)->name,
                'sub_community' => optional($item->psubcommunity)->name,
                'agent_name' => optional($item->user)->name,
                'agent_email' => optional($item->user)->email,
                'agent_phone' => optional($item->user)->phone,
                'image' => $item->images[0] ?? null,
                'date_posted' => Carbon::make($item->created_at)->diffForHumans(),
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json([
            'data' => $transformed,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $rawResult['estimatedTotalHits'] ?? 0,
            ],
        ]);
    }



    public function markAsRead(Request $request)
    {
        $email = Email::find($request->id);
        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Email not found.']);
        }

        $email->is_read = 1;
        $email->save();

        return response()->json(['success' => true, 'message' => 'Email marked as read successfully.']);
    }


    public function searchSuggestions()
    {
        return Cache::remember('search_suggestions', now()->addMinutes(30), function () {
            $properties = NewProperty::with(['pcommunity:id,name', 'psubcommunity:id,name'])
                ->select('country', 'community', 'sub_community')
                ->get();

            $countries = $properties->pluck('country')->filter()->unique()->toArray();

            $communities = $properties
                ->pluck('pcommunity.name')
                ->filter()
                ->unique()
                ->toArray();

            $subCommunities = $properties
                ->pluck('psubcommunity.name')
                ->filter()
                ->unique()
                ->toArray();

            $allNames = array_values(array_unique(array_merge($countries, $communities, $subCommunities)));

            return response()->json($allNames);
        });
    }





}
