<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Actions\GetLatestStatusesByUser;
use App\Http\Resources\StatusResource;
use App\Actions\UpdateProfile;
use Illuminate\Http\Request;
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

             'userId' => auth()->id(),

             'statuses' => StatusResource::collection($getStatuses->handle($name))

         ]);
    }

    public function update(UpdateProfileRequest $request, UpdateProfile $updateProfile)
    {

        $update = $updateProfile->handle($request);

        session()->flash('success', "Your profile has been updated.");

        return redirect()->route('profile-show', $update->name);

    }
}
