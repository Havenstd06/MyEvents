<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TripsController extends Controller
{
    public function create(Request $request, $recordid)
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'max_person' => 'required|min:1|integer',
        ]);

        $user = auth()->user();

        $newTrip = new Trip();
        $newTrip->name = $request->get('name');
        $newTrip->max_person = $request->get('max_person');
        $newTrip->user_id = $user->id;
        $newTrip->event_id = $recordid;
        $newTrip->participants = "[]";
        $newTrip->save();

        return back()->with([
            'data' => [
                'tripJoinLink' => route('trips.join', [
                    'trip_id' => $newTrip->id,
                    'recordid' => $newTrip->event_id
                ])
            ],
            'success' => "$newTrip->name as been successfully created! Share the link to invite friends."
        ]);
    }

}
