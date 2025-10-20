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
        $keywords = $request->input('query', []); // array of keywords
        $filters = [
            'offering_type' => $request->input('offering_type'),
            'completion_status' => $request->input('completion_status'),
            'type' => $request->input('type'),
            'bedroom' => $request->input('bedroom'),
            'bathroom' => $request->input('bathroom'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
        ];

        // 🧭 Pagination setup
        $page = max(1, (int)$request->input('page', 1));
        $limit = min(1000, (int)$request->input('limit', 20));
        $offset = ($page - 1) * $limit;

        // 🧮 Sorting setup
        $sortField = $request->input('sort_field', 'updated_at'); // default sort by date
        $sortOrder = strtolower($request->input('sort_order', 'desc')); // asc | desc

        // Allowed sortable fields
        $allowedSorts = [
            'name' => 'title_en',
            'date' => 'updated_at',
            'price' => 'price',
        ];

        $sortField = $allowedSorts[$sortField] ?? 'updated_at';
        $sortOrder = $sortOrder === 'asc' ? 'asc' : 'desc';


        // 🧩 Build Meilisearch filter string
        $filterConditions = [];

        if (!empty($filters['offering_type'])) {
            $filterConditions[] = 'offering_type = "' . $filters['offering_type'] . '"';
        }
        if (!empty($filters['completion_status'])) {
            $filterConditions[] = 'completion_status = "' . $filters['completion_status'] . '"';
        }
        if (!empty($filters['type'])) {
            $filterConditions[] = 'property_type = "' . $filters['type'] . '"';
        }
        if (is_numeric($filters['bedroom'])) {
            $filterConditions[] = 'bedroom = ' . $filters['bedroom'];
        }
        if (is_numeric($filters['bathroom'])) {
            $filterConditions[] = 'bathroom = ' . $filters['bathroom'];
        }

        if (is_numeric($filters['min_price']) && is_numeric($filters['max_price'])) {
            $filterConditions[] = 'price >= ' . $filters['min_price'] . ' AND price <= ' . $filters['max_price'];
        } elseif (is_numeric($filters['min_price'])) {
            $filterConditions[] = 'price >= ' . $filters['min_price'];
        } elseif (is_numeric($filters['max_price'])) {
            $filterConditions[] = 'price <= ' . $filters['max_price'];
        }

        $filterString = implode(' AND ', $filterConditions);

        $combinedResults = [];

        // 🟢 If there are keywords, search each one
        if (!empty($keywords)) {
            foreach ($keywords as $word) {
                $found = NewProperty::search($word, function ($meilisearch, $query, $options) use ($filterString, $limit, $offset, $sortField, $sortOrder) {
                    if ($filterString) {
                        $options['filter'] = $filterString;
                    }
                    $options['limit'] = $limit;
                    $options['offset'] = $offset;
                    $options['sort'] = [$sortField . ':' . $sortOrder];
                    return $meilisearch->search($query, $options);
                })->get();

                foreach ($found as $item) {
                    $id = $item->id;
                    if (!isset($combinedResults[$id])) {
                        $combinedResults[$id] = ['count' => 0, 'data' => $item];
                    }
                    $combinedResults[$id]['count']++;
                }
            }
        }

        else {
            $found = NewProperty::search('', function ($meilisearch, $query, $options) use ($filterString, $limit, $offset, $sortField, $sortOrder) {
                if ($filterString) {
                    $options['filter'] = $filterString;
                }
                $options['limit'] = $limit;
                $options['offset'] = $offset;
                $options['sort'] = [$sortField . ':' . $sortOrder]; // ✅
                return $meilisearch->search($query, $options);
            })->get();

            foreach ($found as $item) {
                $combinedResults[$item->id] = ['count' => 1, 'data' => $item];
            }
        }

        // Sort by match count (relevance)
        $sorted = collect($combinedResults)
            ->sortByDesc('count')
            ->map(fn($r) => $r['data'])
            ->values();

        $eloquentResults = new EloquentCollection($sorted);
        $eloquentResults->load([
            'pcommunity:id,name',
            'psubcommunity:id,name',
            'user:id,name,email,phone,image',
        ]);

        $data = $eloquentResults->map(function ($item) {
            return [
                'id' => $item->id,
                'title_en' => $item->title_en,
                'slug' => $item->slug,
                'city' => $item->city,
                'community' => $item->pcommunity?->name,
                'sub_community' => $item->psubcommunity?->name,
                'property_type' => $item->property_type,
                'completion_status' => $item->completion_status,
                'offering_type' => $item->offering_type,
                'bedroom' => $item->bedroom,
                'bathroom' => $item->bathroom,
                'price' => $item->price,
                'updated_at' => $item->updated_at,
                'added_date' => Carbon::make($item->updated_at)->diffForHumans(),
                'photo'=>$item->photo,
                'user' => $item->user ? [
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'phone' => $item->user->phone,
                    'image' => $item->user->image,
                ] : null,
            ];
        });

        // 🧾 Response
        return response()->json([
            'page' => $page,
            'limit' => $limit,
            'count' => $data->count(),
            'sort_by' => $sortField,
            'sort_order' => $sortOrder,
            'data' => $data,
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
