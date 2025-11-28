<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\Email;
use App\Models\GlobalProject;
use App\Models\Insight;
use App\Models\ListingSyndication;
use App\Models\MarketingChannels;
use App\Models\NewProperty;
use App\Models\OffPlanProject;
use App\Models\RealEstate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;


class HomeController
{
    public function homePage()
    {

        $countries = DB::table('global_projects')
            ->select('name', 'image')
            ->distinct()
            ->get()
            ->map(function ($country) {
                $country->name = strtolower($country->name);
                return $country;
            });


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

        $properties = NewProperty::select(
            'id', 'title_en', 'slug', 'city', 'community', 'sub_community',
            'property_type', 'completion_status', 'offering_type','size',
            'bedroom', 'bathroom', 'price', 'photo', 'updated_at'
        )
            ->where('featured', 1)
            ->get()
            ->map(function ($property) {
                $property->added_at = $property->updated_at->diffForHumans();
                return $property;
            });

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
            ->select('name', 'image','slug')
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
    public function offplanProjects(Request $request)
    {
        $limit = (int) $request->limit > 0 ? (int) $request->limit : 20;

        // 🧠 Use only selected columns for pagination (faster query)
        $offplan_projects = OffPlanProject::query()
            ->select('id', 'image', 'title', 'link as slug', 'developer', 'completion_date', 'location','starting_price')
            ->paginate($limit);

        // 🧠 Retrieve distinct filters in one query (if filters are needed)
        $filters = OffPlanProject::select('developer', 'completion_date', 'location', 'link')->get();

        $searchFilters = [
            'developers' => $filters->pluck('developer')->filter()->unique()->values(),
            'completion_date' => $filters->pluck('completion_date')->filter()->unique()->values(),
            'locations' => $filters->mapWithKeys(function ($item) {
                return [$item->link => $item->location];
            })->unique(),
        ];



        return response()->json([
            'filters' => $searchFilters,
            'data' => $offplan_projects->items(),
            'pagination' => [
                'total' => $offplan_projects->total(),
                'per_page' => $offplan_projects->perPage(),
                'current_page' => $offplan_projects->currentPage(),
                'last_page' => $offplan_projects->lastPage(),
                'from' => $offplan_projects->firstItem(),
                'to' => $offplan_projects->lastItem(),
            ],
        ]);
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
    public function updateShares(Request $request, $id)
    {

        switch ($request->type) {
            case 'blog':
                $model = \App\Models\Blog::find($id);
                break;
            case 'news':
                $model = \App\Models\Insight::find($id);
                break;
            default:
                $model = \App\Models\Insight::find($id);
                break;
        }

        if (!$model) {
            return response()->json(['message' => ucfirst($request->type) . ' not found'], 404);
        }

        $model->shares = $model->shares + 1;
        $model->save();

        return response()->json([
            'message' => ucfirst($request->type) . ' shares updated successfully',
            'shares' => $model->shares,
        ]);
    }


    public function blogs(Request $request)
    {
        $limit = $request->input('limit', 9);

        $blogs = Blog::with('blog_image')
            ->select('id', 'title', 'slug', 'created_at', 'posted_by', 'title_details')
            ->paginate($limit);

        return response()->json([
            'data' => $blogs->items(),
            'pagination' => [
                'total' => $blogs->total(),          // total number of items
                'per_page' => $blogs->perPage(),     // items per page
                'current_page' => $blogs->currentPage(), // current page number
                'last_page' => $blogs->lastPage(),   // total number of pages
                'from' => $blogs->firstItem(),       // first item number on this page
                'to' => $blogs->lastItem(),          // last item number on this page
            ]
        ]);
    }

    public function news(Request $request)
    {
        $limit = $request->input('limit', 6);

        $news = Insight::select('id', 'title', 'slug', 'image', 'created_at')
            ->paginate($limit);

        return response()->json([
            'data' => $news->items(),
            'pagination' => [
                'total' => $news->total(),
                'per_page' => $news->perPage(),
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'from' => $news->firstItem(),
                'to' => $news->lastItem(),
            ]
        ]);
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

    private function handleContactRequest(Request $request)
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
            'type' => $request->type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Your request has been submitted successfully. Our team will contact you soon.'
        ]);
    }


    public function search(Request $request)
    {
        // 📝 Keywords
        $keywords = $request->input('query', []);

        // 🧪 Filters
        $filters = [
            'offering_type' => $request->input('offering_type'),
            'completion_status' => $request->input('completion_status'),
            'type' => $request->input('type'),
            'bedroom' => $request->input('bedroom'),
            'bathroom' => $request->input('bathroom'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
        ];

        // 🧭 Pagination
        $page = max(1, (int)$request->input('page', 1));
        $limit = 5; // Always 5 per page
        $offset = ($page - 1) * $limit;

        // 🔽 Sorting
        $sortField = $request->input('sort_field', 'updated_at');
        $sortOrder = strtolower($request->input('sort_order', 'desc'));

        $allowedSorts = [
            'name' => 'title_en',
            'date' => 'updated_at',
            'price' => 'price',
        ];

        $sortField = $allowedSorts[$sortField] ?? 'updated_at';
        $sortOrder = $sortOrder === 'asc' ? 'asc' : 'desc';

        // 🧩 Build filter string
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

        // 🟢 RESULTS COLLECTION
        $combinedResults = [];
        $totalHits = 0;

        // 🔍 SEARCH WITH KEYWORDS
        if (!empty($keywords)) {
            foreach ($keywords as $word) {

                $raw = NewProperty::search($word, function ($meilisearch, $query, $options)
                use ($filterString, $limit, $offset, $sortField, $sortOrder) {

                    if ($filterString) {
                        $options['filter'] = $filterString;
                    }

                    $options['limit'] = $limit;
                    $options['offset'] = $offset;
                    $options['sort'] = [$sortField . ':' . $sortOrder];

                    return $meilisearch->search($query, $options);
                })->raw();

                $totalHits = $raw['estimatedTotalHits'] ?? $raw['totalHits'] ?? $totalHits;
                $hits = $raw['hits'] ?? [];

                foreach ($hits as $item) {
                    $id = $item['id'];
                    if (!isset($combinedResults[$id])) {
                        $combinedResults[$id] = ['count' => 0];
                    }
                    $combinedResults[$id]['count']++;
                }
            }
        }

        // 🔍 SEARCH WITHOUT KEYWORDS
        else {
            $raw = NewProperty::search('', function ($meilisearch, $query, $options)
            use ($filterString, $limit, $offset, $sortField, $sortOrder) {

                if ($filterString) {
                    $options['filter'] = $filterString;
                }

                $options['limit'] = $limit;
                $options['offset'] = $offset;
                $options['sort'] = [$sortField . ':' . $sortOrder];

                return $meilisearch->search($query, $options);
            })->raw();

            $totalHits = $raw['estimatedTotalHits'] ?? $raw['totalHits'] ?? 0;
            $hits = $raw['hits'] ?? [];

            foreach ($hits as $item) {
                $combinedResults[$item['id']] = ['count' => 1];
            }
        }

        // 📌 SORT BY MATCH COUNT
        $sortedIds = collect($combinedResults)
            ->sortByDesc('count')
            ->keys()
            ->toArray();

        // 🔄 GET REAL ELOQUENT MODELS
        $eloquentResults = NewProperty::whereIn('id', $sortedIds)
            ->with([
                'pcommunity:id,name',
                'psubcommunity:id,name',
                'user:id,name,email,phone,image',
            ])
            ->get()
            ->sortBy(function ($item) use ($combinedResults) {
                return $combinedResults[$item->id]['count'] ?? 0;
            })
            ->values();

        // 🧱 TRANSFORM DATA
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
                'currency' => $item->currency,
                'updated_at' => $item->updated_at,
                'added_date' => Carbon::make($item->updated_at)->diffForHumans(),
                'photo' => $item->photo,
                'user' => $item->user ? [
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                    'phone' => $item->user->phone,
                    'image' => $item->user->image,
                ] : null,
            ];
        });

        // 📤 RESPONSE
        return response()->json([
            'page' => $page,
            'limit' => $limit,
            'total' => $totalHits,
            'total_pages' => ceil($totalHits / $limit),
            'count' => $data->count(),
            'sort_by' => $sortField,
            'sort_order' => $sortOrder,
            'data' => $data,
        ]);
    }


    public function searchOffplan(Request $request)
    {
        $filters = [
            'developer' => $request->input('developers', []),
            'completion_date' => $request->input('completion_date'),
            'link' => $request->input('locations', []),
        ];


        // 🧭 Pagination setup
        $page = max(1, (int)$request->input('page', 1));
        $limit = min(100, (int)$request->input('limit', 20));
        $offset = ($page - 1) * $limit;

        // 🧮 Sorting setup
        $sortField = $request->input('sort_field', 'updated_at');
        $sortOrder = strtolower($request->input('sort_order', 'desc'));
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

        $allowedSorts = [
            'name' => 'title',
            'date' => 'updated_at',
            'price' => 'price',
        ];
        $sortField = $allowedSorts[$sortField] ?? 'updated_at';

        // 🧩 Build Meilisearch filter string
        $filterConditions = [];

        if (!empty($filters['developer'])) {
            $devFilters = collect($filters['developer'])
                ->map(fn($dev) => 'developer = "' . addslashes($dev) . '"')
                ->join(' OR ');
            $filterConditions[] = "($devFilters)";
        }



        if (!empty($filters['completion_date'])) {
            $filterConditions[] = 'completion_date = "' . addslashes($filters['completion_date']) . '"';
        }
        if (!empty($filters['link'])) {
            $locFilters = collect($filters['link'])
                ->map(fn($loc) => 'link = "' . addslashes($loc) . '"')
                ->join(' OR ');
            $filterConditions[] = "($locFilters)";
        }

        $filterString = implode(' AND ', $filterConditions);

        // 🧭 Perform Meilisearch query
        $searchResult = OffPlanProject::search('', function ($meilisearch, $query, $options) use ($filterString, $limit, $offset, $sortField, $sortOrder) {
            if (!empty($filterString)) {
                $options['filter'] = $filterString;
            }
            $options['limit'] = $limit;
            $options['offset'] = $offset;
            $options['sort'] = [$sortField . ':' . $sortOrder];
            return $meilisearch->search($query, $options);
        });

        // Get the raw Meilisearch metadata
        $raw = $searchResult->raw();

        // Extract hits
        $results = collect($raw['hits'] ?? []);

        // 🧾 Format response
        $data = $results->map(function ($item) {
            return [
                'id' => $item['id'] ?? null,
                'title' => $item['title'] ?? null,
                'slug' => $item['link'] ?? null,
                'image' => $item['image'] ?? null,
                'developer' => $item['developer'] ?? null,
                'completion_date' => $item['completion_date'] ?? null,
                'location' => $item['location'] ?? null,
                'price' => $item['starting_price'] ?? null,
                'updated_at' => $item['updated_at'] ?? null,
            ];
        });

        // 🧮 Calculate pagination info
        $total = $raw['estimatedTotalHits'] ?? $data->count();
        $lastPage = (int) ceil($total / $limit);
        $from = $offset + 1;
        $to = min($offset + $limit, $total);

        return response()->json([
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'last_page' => $lastPage,
                'from' => $total > 0 ? $from : null,
                'to' => $total > 0 ? $to : null,
            ],
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
            $communities = $properties->pluck('pcommunity.name')->filter()->unique()->toArray();
            $subCommunities = $properties->pluck('psubcommunity.name')->filter()->unique()->toArray();

            $allNames = array_values(array_unique(array_merge($countries, $communities, $subCommunities)));

            // 🔹 Make associative array: key = value
            $associative = collect($allNames)->mapWithKeys(fn($item) => [$item => $item])->toArray();

            return response()->json($associative);
        });
    }


    public function searchOffplanSuggestions()
    {

        $filters = OffPlanProject::select('developer', 'completion_date', 'location', 'link')->get();

        $searchFilters = [
            'developers' => $filters->pluck('developer')->filter()->unique()->values(),
            'completion_date' => $filters->pluck('completion_date')->filter()->unique()->values(),
            'locations' => $filters->mapWithKeys(function ($item) {
                return [$item->link => $item->location];
            })->unique(),
        ];

        return response()->json($searchFilters);
    }

    public function faqs(Request $request)
    {

        $type = $request->type;
        $faqs = DB::table('faqs')
            ->where('type', $type)
            ->select('id', 'question', 'answer')
            ->get();

        return response()->json($faqs);
    }

    public function teams()
    {
        $teams = User::where('publish_to_web_site', true)->get();
        return response()->json($teams);
    }

    public function teamDetails($slug)
    {

        $team = User::where('slug', $slug)->first();
        $otherTeams = User::where('publish_to_web_site', true)
            ->where('slug', '!=', $slug)
            ->get();

        if (!$team) {
            return response()->json(['message' => 'Team member not found'], 404);
        }
        return response()->json([
            'team' => $team,
            'other_teams' => $otherTeams,
        ]);
    }

    public function offplanProjectDetails($slug)
    {
        $offplan = OffPlanProject::where('link', $slug)
            ->select('id', 'title', 'link', 'image', 'developer', 'completion_date', 'location', 'starting_price',
                'project_size', 'lifestyle', 'title_type',
                'first_installment', 'area', 'description',
                'during_construction', 'on_handover', 'features', 'map_link', 'order','youtube_link','header_images')
            ->first();
        // make header_images array as associative array with id and url
        $offplan->header_images = json_decode($offplan->header_images,true) ?? [];
        $offplan->header_images = array_map(function ($image, $index) {
            return [
                'id' => $index + 1,
                'url' => $image,
            ];
        }, $offplan->header_images ?? [], array_keys($offplan->header_images ?? []));


        if (!$offplan) {
            return response()->json(['message' => 'Off-Plan Project not found'], 404);
        }
        return response()->json($offplan);
    }

    public function globalProjectDetails($name)
    {
        $project=GlobalProject::with('user:name,phone,id,image')->where('name',$name)->first();

        $similarProjects=NewProperty::
              with([
            'user:id,name,email,phone,image',
             ])
            ->where('country',ucfirst($name))
            ->select('id','title_en','slug','price','bedroom','bathroom','photo','offering_type','user_id')
            ->take(10)
            ->get();

        $fallBackProjects=NewProperty::
              with([
            'user:id,name,email,phone,image',
             ])
            ->select('id','title_en','slug','price','bedroom','bathroom','photo','offering_type','user_id')
            ->take(10)
            ->get();

        if ($similarProjects->isEmpty()) {
            $similarProjects = $fallBackProjects;
        }

        if (!$project) {
            return response()->json(['message' => 'Global Project not found'], 404);
        }
        return response()->json([
            'project'=>$project,
            'similar_properties'=>$similarProjects,
        ]);
    }

    public function popularAreaDetails($slug)
    {
        $area=DB::table('communities')
            ->where('slug', $slug)
            ->select('id','name','slug','image','description','location','youtube')
            ->first();

        $suggestedProperties=NewProperty::
             with('user:id,name,image,phone')
            ->where('community',$area->id)
            ->where('offering_type','RS')
            ->select('id','title_en','slug','price','bedroom','bathroom','photo','offering_type','user_id')
            ->take(10)
            ->get();


        if (!$area) {
            return response()->json(['message' => 'Popular Area not found'], 404);
        }
        return response()->json([
            'area'=>$area,
            'suggested_properties'=>$suggestedProperties,
        ]);
    }

    public function propertyDetails($slug)
    {
        $property = NewProperty::with([
            'pcommunity:id,name',
            'psubcommunity:id,name',
            'propertyImages',
            'user:id,name,email,phone,image'
        ])
            ->where('slug', $slug)
            ->first();

        $similarProperties = NewProperty::with('user:id,name,image,phone')
            ->where('community', $property->community)
            ->where('id', '!=', $property->id)
            ->select('id', 'title_en', 'slug', 'price', 'bedroom', 'bathroom', 'photo', 'offering_type','user_id')
            ->take(10)
            ->get();

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $data = $property->toArray();
        $data['community'] = $property->pcommunity->name ?? null;
        $data['sub_community'] = $property->psubcommunity->name ?? null;

        return response()->json([
            'property' => $data,
            'similar_properties' => $similarProperties,
        ]);
    }

    public function realEstateGuides()
    {
        //add /storage to images
        $guides=RealEstate::all()->map(function ($guide) {
            $guide->image = asset('storage/' . $guide->image);
            return $guide;
        });
        return response()->json($guides);
    }
    public function downloadGuide($id)
    {
        $guide = RealEstate::find($id);
        $filename = $guide ? $guide->pdf : null;

        if (!$guide) {
            return response()->json(['message' => 'Guide not found'], 404);
        }

        $filePath = public_path('/storage/realestatepdf/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['message' => 'Guide file not found'], 404);
        }
    }

    public function whoDownloadsGuide(Request $request)
    {

     $store=DB::table('downloaded_brochures')
            ->insert([
                'brochure_name' => $request->brochure_name,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json(['message' => 'Information stored successfully']);
    }

    public function leatestListings()
    {
        $listings = NewProperty::
        where('offering_type', 'RS')
        ->select('id', 'title_en', 'slug', 'city', 'price', 'photo')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return response()->json($listings);
    }
}
