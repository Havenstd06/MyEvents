<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('/Profil/user', [
            'sessions' => $this->sessions($request)->all(),
        ]);
    }
}
