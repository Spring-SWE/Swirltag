<?php

namespace App\Http\Controllers;

use App\Actions\GetLatestStatusesByUser;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the Users Statuses posted on their timeline.
     */
    public function show(string $name, GetLatestStatusesByUser $getStatuses): Response
    {
         return Inertia::render('Profile/Timeline', [

             'user' => User::where('name', $name)->firstOrFail(),

             'statuses' => $getStatuses->handle($name)

         ]);
    }
}
