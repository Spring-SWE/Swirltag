<?php

namespace App\Http\Controllers;

use App\Actions\GetLatestStatusesByUser;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the Users Statuses posted on their timeline.
     */
    public function show(string $name, GetLatestStatusesByUser $getStatuses, Request $request)
    {
        if($request->wantsJson()) {

            return StatusResource::collection($getStatuses->handle($name))->response()->getData(true);

         }

         return Inertia::render('Profile/Timeline', [

             'user' => User::where('name', $name)->firstOrFail(),

             'statuses' => StatusResource::collection($getStatuses->handle($name))

         ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:255',
        ]);



        return redirect()->back();
    }
}
