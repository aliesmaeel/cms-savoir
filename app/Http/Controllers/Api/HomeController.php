<?php

namespace App\Http\Controllers\Api;

use App\Models\ListingSyndication;
use App\Models\MarketingChannels;
use App\Models\OffPlanProject;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function homePage()
    {
        $countries = DB::table('countries')
                ->select('name','image')->distinct()->get();

        $search = [];


        foreach ($countries as $country) {
            // Get all communities in this country
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

        $properties = DB::table('new_properties')
            ->select('id','offering_type','price','slug','bedroom','bathroom','size','parking','photo','completion_status')
            ->where('featured', 1)
            ->whereIn('completion_status', ['off_plan', 'completed'])
            ->where(function ($q) {
                $q->whereNull('offering_type')
                    ->orWhereIn('offering_type', ['RR', 'RS']);
            })
            ->orderByDesc('id')
            ->get();

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
        $insights = DB::table('insights')
            ->select('id', 'title', 'slug', 'image','description')
            ->take(4)
            ->get();
        $areas=DB::table('communities')
            ->select('name','image')->take(6)->get();

        $testimonials = DB::table('testimonials')
            ->select('id', 'name', 'position', 'image', 'message')
            ->get();
        $offplan_projects = OffPlanProject::select('id', 'image', 'link')
            ->orderBy('order', 'asc')
            ->take(5)
            ->get();
        $marketChannels=MarketingChannels::select('id','image')->get();
        $listingSyndication=ListingSyndication::select('id','image')->get();

        return response()->json([
            'search' => $search,
            'featured_properties' => $grouped,
            'countries'=>$countries,
            'insights'=>$insights,
            'areas'=>$areas,
            'testimonials'=>$testimonials,
            'offplan_projects'=>$offplan_projects,
            'marketChannels'=>$marketChannels,
            'listingSyndications'=>$listingSyndication,
        ]);
    }
}
