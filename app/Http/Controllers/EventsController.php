<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class EventsController extends Controller
{

    public function home()
    {
        return Inertia::render('Home');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function show(Request $request, $recordid)
    {
        $user = auth()->user();
        $userTrips = [];

        if ($user) {
            $userTrips = Trip::where('user_id', $user->id)->where('event_id', $recordid)->get();
        }

        return Inertia::render('Events/Show', compact('recordid', 'userTrips'));
    }
}
