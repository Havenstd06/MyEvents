<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{

    public function profile($user)
    {
        $user = User::where('id', $user)->firstOrFail();
        $userOrganizedTrips = [];
        $userJoinedTrips = [];

        if ($user) {
            $userOrganizedTrips = Trip::where('user_id', $user->id)->get();

            $allTrips = Trip::all();

            foreach ($allTrips as $trip) {
                foreach ($trip->participants as $participant) {
                    if ($participant['id'] === $user->id && $user->id !== $trip->user->id) {
                        $userJoinedTrips = array_merge($userJoinedTrips, [$trip->toArray()]);
                    }
                }
            }
        }

        return Inertia::render('Users/Profile', [
            'user' => $user,
            'userOrganizedTrips' => $userOrganizedTrips,
            'userJoinedTrips' => $userJoinedTrips,
        ]);
    }

    public function edit()
    {
        $user = auth()->user();
        $userCreatedAtForHumans = $user->created_at->format('d/m/Y H:m:s');

        return Inertia::render('Users/Edit', [
            'user'                    => $user,
            'userCreatedAtForHumans'  => $userCreatedAtForHumans
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
            'description' => 'required|min:20|max:1000',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email') !== $user->email ? $request->get('email') : $user->email;
        $user->description = $request->get('description');

        $user->save();

        return back()->with('success', 'Bravo ta modifier ton profile');
    }
}
