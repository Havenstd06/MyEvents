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
            'description' => 'required|min:20|max:1000',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email') !== $user->email ? $request->get('email') : $user->email;
        $user->description = $request->get('description');

        $user->save();

        return back()->with('success', 'Bravo ta modifier ton profile');
    }
}
