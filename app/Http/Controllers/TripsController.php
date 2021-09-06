<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TripsController extends Controller
{
    public function create(Request $request, $recordid)
    {
        $request->validate([
            'name'          => 'required|min:1|max:255',
            'max_person'    => 'required|min:1|integer',
            'is_public'     => 'boolean',
        ]);

        $event_data = [
            'name' => $request->get('event_name'),
            'image' => $request->get('event_image') ?? 'https://limg.app/i/gHlTvX.png',
            'date' => $request->get('event_date'),
        ];

        $user = auth()->user();

        $newTrip = new Trip();
        $newTrip->name = $request->get('name');
        $newTrip->max_person = $request->get('max_person');
        $newTrip->is_public = $request->get('is_public');
        $newTrip->user_id = $user->id;
        $newTrip->event_id = $recordid;
        $newTrip->event_data = json_encode($event_data);
        $newTrip->participants = json_encode([$user->toArray()]);
        $newTrip->save();

        $newRoom = new Room();
        $newRoom->trip_id = $newTrip->id;
        $newRoom->save();

        return back()->with([
            'data' => [
                'tripJoinLink' => route('trips.join.show', [
                    'trip_id' => $newTrip->id,
                    'recordid' => $newTrip->event_id
                ]),
                'tripId' => $newTrip->id,
                'trip' => $newTrip
            ],
            'success' => "$newTrip->name as been successfully created! Share the link to invite friends."
        ]);
    }

    public function showJoin(Request $request, $trip_id, $recordid)
    {
        $user = auth()->user();
        $trip = Trip::where('id', $trip_id)->firstOrFail();
        $organizer = $trip->user;

        if ($trip->is_public === 'private') {
            return redirect()
                ->back()
                ->with('error', 'This trip is private, you must be invited to join.');
        }

        foreach ($trip->participants as $participant) {
            if ($participant['id'] === $user->id) {
                return redirect()
                    ->back()
                    ->with('error', 'You have already joined trip!');
            }
        }

        return Inertia::render('Trips/Join', [
            'trip'      => $trip,
            'organizer' => $organizer,
            'recordid'  => $recordid
        ]);
    }

    public function join(Request $request, $trip_id, $recordid)
    {
        $trip = Trip::where('id', $trip_id)->firstOrFail();
        $organizer = $trip->user;
        $joinedUser = auth()->user();

        if ($joinedUser->id === $organizer->id) {
            return redirect()
                ->route('events.show', ['recordid' => $trip->event_id])
                ->with('error', 'You cannot rejoin your own trip!');
        }

        foreach ($trip->participants as $participant) {
            if ($participant['id'] === $joinedUser->id) {
                return redirect()
                    ->back()
                    ->with('error', 'You have already joined trip!');
            }
        }

        if (count($trip->participants) >= $trip->max_person) {
            return redirect()
                ->route('events.show', ['recordid' => $trip->event_id])
                ->with('error', 'This trip is full!');
        }

        $trip->participants =
            json_encode(
                array_merge(
                    $trip->participants,
                    [$joinedUser->toArray()]
                )
            );
        $trip->save();

        return redirect()
            ->route('trips.show', ['trip_id' => $trip->id])
            ->with('success', 'You have successfully joined the trip!');
    }

    public function forceJoin(Request $request, $trip_id, $recordid)
    {
        $request->validate([
            'email'  => 'required|email|exists:users',
        ]);

        $trip = Trip::where('id', $trip_id)->firstOrFail();
        $organizer = $trip->user;
        $joinedUser = User::where('email', $request->get('email'))->firstOrFail();

        if ($joinedUser->id === $organizer->id) {
            return redirect()
                ->back()
                ->with('error', 'You cannot force join yourself on your own trip!');
        }

        foreach ($trip->participants as $participant) {
            if ($participant['id'] === $joinedUser->id) {
                return redirect()
                    ->back()
                    ->with('error', 'This user has already joined trip!');
            }
        }

        if (count($trip->participants) >= $trip->max_person) {
            return redirect()
                ->back()
                ->with('error', 'This trip is full!');
        }

        $trip->participants =
            json_encode(
                array_merge(
                    $trip->participants,
                    [$joinedUser->toArray()]
                )
            );

        $trip->save();

        return redirect()
            ->back()
            ->with('success', "You have successfully added '$joinedUser->name' to the trip!");
    }

    public function show(Request $request, $tripId)
    {
        $user = auth()->user();
        $trip = Trip::where('id', $tripId)->firstOrFail();
        $participantsId = [];
        $participants = [];

        foreach ($trip->participants as $participant) {
            $participantsId[] = $participant['id'];

            $participants[] = User::where('id', $participant['id'])->firstOrFail();
        }

        if (! in_array($user->id, $participantsId)) {
            return redirect()
                ->back()
                ->with('error', 'You have not joined this trip!');
        }

        return Inertia::render('Trips/Show', [
            'trip'              => $trip,
            'organizer'         => $trip->user,
            'participants'      => $participants,
            'google_api_key'    => config('services.google.api_key')
        ]);
    }

    public function update(Request $request, $tripId)
    {
        $request->validate([
            'name'          => 'required|min:1|max:255',
            'max_person'    => 'required|min:1|integer',
            'is_public'     => 'boolean',
        ]);

        $user = auth()->user();
        $trip = Trip::where('id', $tripId)->firstOrFail();

        if ($user->id !== $trip->user->id) {
            return redirect()
                ->route('trips.show', ['trip_id' => $trip->id])
                ->with('error', 'You are not the trip owner!');
        }

        $maxPerson = $request->get('max_person');

        if ($maxPerson < count($trip->participants)) {
            return redirect()
                ->back()
                ->with('error', 'You cannot set a maximum number of participants lower than the current number of participants.');
        }

        $trip->name = $request->get('name');
        $trip->max_person = $maxPerson;
        $trip->is_public = $request->get('is_public');

        $trip->save();

        return redirect()
            ->back()
            ->with('success', 'You have successfully updated the trip!');
    }

    public function removeUser(Request $request, $tripId, int $userId)
    {
        $user = auth()->user();
        $trip = Trip::where('id', $tripId)->firstOrFail();
        $removedUser = User::where('id', $userId)->firstOrFail();

        if ($user->id !== $trip->user->id) {
            return redirect()
                ->route('trips.show', ['trip_id' => $trip->id])
                ->with('error', 'You are not the trip owner!');
        }

        if ($userId === $trip->user->id) {
            return redirect()
                ->route('trips.show', ['trip_id' => $trip->id])
                ->with('error', 'You can\'t remove yourself from your trip!');
        }

        $newParticipants = $trip->participants;

        foreach ($newParticipants as $key => $item){
            if ($item['id'] === $userId) {
                unset($newParticipants[$key]);
            }
        }

        $trip->participants = $newParticipants;
        $trip->save();

        return redirect()
            ->back()
            ->with('success', "You have successfully remove '$removedUser->name' from your trip!");
    }

    public function leaveUser(Request $request, $tripId, int $userId)
    {
        $user = auth()->user();
        $trip = Trip::where('id', $tripId)->firstOrFail();
        $removedUser = User::where('id', $userId)->firstOrFail();

        if ($user->id !== $removedUser->id) {
            return redirect()
                ->route('trips.show', ['trip_id' => $trip->id])
                ->with('error', 'You cant remove other participants!');
        }

        if ($userId === $trip->user->id) {
            return redirect()
                ->route('trips.show', ['trip_id' => $trip->id])
                ->with('error', 'You can\'t leave your trip!');
        }

        $newParticipants = $trip->participants;

        foreach ($newParticipants as $key => $item){
            if ($item['id'] === $userId) {
                unset($newParticipants[$key]);
            }
        }

        $trip->participants = $newParticipants;
        $trip->save();

        return redirect()
            ->route('home')
            ->with('success', "You have successfully leave this trip!");
    }

    public function delete(Request $request, $tripId)
    {
        $user = auth()->user();
        $trip = Trip::where('id', $tripId)->firstOrFail();

        if ($user->id !== $trip->user->id) {
            return redirect()
                ->route('trips.show', ['trip_id' => $trip->id])
                ->with('error', 'You are not the trip owner!');
        }

        $trip->delete();

        return redirect()
            ->route('home')
            ->with('success', 'You have successfully deleted the trip!');
    }
}
