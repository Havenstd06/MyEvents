<?php

namespace App\Http\Controllers;

use App\ViewModels\EventsViewModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class EventsController extends Controller
{
    /**
     */
    public function home()
    {
        $trendingEvents = Http::get('https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&lang=fr&rows=18&facet=tags&facet=placename&facet=department&facet=region&facet=city&facet=date_start&facet=date_end&facet=pricing_info&facet=updated_at&facet=city_district&refine.city=Marseille&timezone=Europe%2FParis')
            ->json()['records'];

        return Inertia::render('Home', compact('trendingEvents'));
    }
}
