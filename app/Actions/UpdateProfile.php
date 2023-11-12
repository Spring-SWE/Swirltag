<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UpdateProfile
{

    public function handle($request)
    {
        $user = User::find($request->input('userId'));

        // Validate the user is the same as the logged-in user
        if ($user->id == $request->user()->id) {
            $user->description = $request->input('description');
            $user->website = $request->input('website');
            $user->name = $request->input('name');

            if ($request->hasFile('avatar')) {
                // Get the uploaded file
                $avatarFile = $request->file('avatar');

                // Check if the uploaded file is not the default usericon.png
                if ($user->avatar !== '/media/avatars/usericon.png') {
                    // Remove the previous avatar unless it's the default usericon.png
                    Storage::disk('public')->delete($user->avatar);
                }

                // Store the new avatar
                $avatarPath = $avatarFile->store('media/avatars', 'public');
                $user->avatar = $avatarPath;
                $user->save();
            } else {
                // No new avatar uploaded, keep the existing one
            }

            $user->save();

            return $user;
        } else {
            // Return back with an error message
            return back()->with('error', 'You can only update your own profile');
        }
    }
}
