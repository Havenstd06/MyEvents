<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
