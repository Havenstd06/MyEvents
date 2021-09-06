<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use finfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'name'          => 'required|min:1|max:255',
            'email'         => 'required|min:1|max:255|email',
            'description'   => 'required|min:5|max:1000',
            'avatar'        => 'file'
        ]);

        $avatar = $request->file('avatar');

        $user->name = $request->get('name');
        $user->email = $request->get('email') !== $user->email ? $request->get('email') : $user->email;
        $user->description = $request->get('description');
        $user->avatar = $avatar ? $this->avatar($user, $avatar->getPathname()) : 'avatars/default.png';
        $user->save();

        return back()->with('success', 'Bravo ta modifier ton profile bg!');
    }

    /**
     * Delete the current user's profile photo.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyProfileAvatar(Request $request)
    {
        $request->user()->deleteProfilePhoto();

        return back(303)
            ->with('success', 'Your avatar has been successfully deleted!');
    }

    private function avatar(User $user, string $avatarUrl)
    {
        $avatarContents = file_get_contents($avatarUrl);
        $avatarExtension = str_replace('image/', '', $this->getMimeType($avatarContents, 'str'));
        $avatarName = 'avatars/'.strtolower(Str::random(6).'-'.$user->id).".$avatarExtension";

        Storage::disk('public')->put($avatarName, $avatarContents);

        return $avatarName;
    }

    private function getMimeType($r, $t = 'file') {
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        return ($t =='str') ? $finfo->buffer($r) : $finfo->file($r);
    }
}
