<?php

namespace App\Http\Controllers;

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
        return Inertia::render('Events/Show', compact('recordid'));
    }
}
