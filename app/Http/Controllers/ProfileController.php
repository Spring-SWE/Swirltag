<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(string $name): Response
    {
         return Inertia::render('Profile/Timeline', [

             'user' => User::where('name', $name)->firstOrFail(),

         ]);
    }
}
