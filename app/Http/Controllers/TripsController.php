<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
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
        $newTrip->participants = json_encode([$user->toArray()]);
        $newTrip->save();

        return back()->with([
            'data' => [
                'tripJoinLink' => route('trips.join.show', [
                    'trip_id' => $newTrip->id,
                    'recordid' => $newTrip->event_id
                ])
            ],
            'success' => "$newTrip->name as been successfully created! Share the link to invite friends."
        ]);
    }

    public function showJoin(Request $request, $trip_id, $recordid)
    {
        $trip = Trip::where('id', $trip_id)->firstOrFail();
        $organizer = $trip->user;

        return Inertia::render('Trips/Join', [
            'trip' => $trip,
            'organizer' => $organizer,
            'recordid' => $recordid
        ]);
    }

    public function join(Request $request, $trip_id, $recordid)
    {
        $trip = Trip::where('id', $trip_id)->firstOrFail();
        $organizer = $trip->user;
        $joinedUser = User::where('id', $request->get('user_id'))->firstOrFail();

        if ($joinedUser->id === $organizer->id) {
            return redirect()
                ->route('events.show', ['recordid' => $trip->event_id])
                ->with('error', 'You cannot rejoin your own trip!');
        }

        foreach ($trip->participants as $participant) {
            if ($participant['id'] === $joinedUser->id) {
                return redirect()
                    ->route('events.show', ['recordid' => $trip->event_id])
                    ->with('error', 'You have already joined trip!');
            }
        }

        if (! empty($trip->participants)) {
            $trip->participants =
                json_encode(
                    array_merge(
                        $trip->participants,
                        [$joinedUser->toArray()]
                    )
                );
        } else {
            $trip->participants = json_encode(
                [$joinedUser->toArray()]
            );
        }
        $trip->save();

        return redirect()
            ->route('events.show', ['recordid' => $trip->event_id])
            ->with('success', 'You have successfully joined the trip!');
    }

}
