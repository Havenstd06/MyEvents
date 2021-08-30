<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class UsersController extends Controller
{

    public function profile()
    {
        $user = auth()->user();
        $userCreatedAtForHumans = $user->created_at->format('d/m/Y H:m:s');

        return Inertia::render('Users/Profile', [
            'user'                    => $user,
            'userCreatedAtForHumans'  => $userCreatedAtForHumans
        ]);
    }

    public function updateUser(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
            'description' => 'require|min:20|max:1000|description',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email') !== $user->email ? $request->get('email') : $user->email;
        $user->description = $request->get('description');

//        $v = validator($user->toArray(), [
//           'name' => 'required|min:1|max:255',
//           'email' => 'required|min:1|max:255|email',
//        ]);
//
//        if ($v->fails()) {
//            return back()->with('success', '')
//        }

        $user->save();

        return back()->with('success', 'Bravo ta modifier ton profile');

//        $user->name = $request->name ?? $user->name;
//
//        if ($request->file('avatar')->isValid()) {
//            $extension = $request->avatar->extension();
//            $path      = $request->avatar->storeAs($user->name . '/avatar', 'avatar.' . $extension, 'public');
//            $url       =  $user->name . '/avatar/' . 'avatar.' . $extension;
//        }
//
//        $user->avatar = $url ?? $user->avatar;
//        $save = $user->save();
//
//        if ($save) {
//            $success["user"] = $user;
//            return $this->sendResponse($success, "Utilisateur");
//        } else {
//            return $this->sendError("Echec de mise à jour", ['error' => 'Unauthorised']);
//        }
    }
}
