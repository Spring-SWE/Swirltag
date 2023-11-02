<?php

namespace App\Http\Controllers;

use App\Actions\GetLatestThreadsByUser;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the Users Threads posted on their timeline.
     */
    public function showTimeline(string $name, GetLatestThreadsByUser $getThreads): Response
    {
         return Inertia::render('Profile/Timeline', [

             'user' => User::where('name', $name)->firstOrFail(),

             'threads' => $getThreads->handle($name)

         ]);
    }
}
