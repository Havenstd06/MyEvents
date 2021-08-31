<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class EventsController extends Controller
{

    public function home()
    {
        $trendingEvents = Http::get('https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&lang=fr&rows=18&facet=tags&facet=placename&facet=department&facet=region&facet=city&facet=date_start&facet=date_end&facet=pricing_info&facet=updated_at&facet=city_district&refine.city=Marseille&timezone=Europe%2FParis')
            ->json()['records'];

        return Inertia::render('Home', compact('trendingEvents'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function show(Request $request, $recordid)
    {
        $event = Http::get("https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&lang=fr&rows=18&facet=tags&facet=placename&facet=department&facet=region&facet=city&facet=date_start&facet=date_end&facet=pricing_info&facet=updated_at&facet=city_district&facet=recordid&refine.city=Marseille&refine.recordid=$recordid&timezone=Europe%2FParis")
            ->json()['records'][0];

        return Inertia::render('Events/Show', compact('event'));
    }
}
