<?php

namespace App\Actions;

use App\Models\User;

class UpdateProfile
{

    public function handle($request)
    {
        $user = User::find($request->input('userId'));

        //validate the user is the same as the logged in user
        if($user->id == auth()->user()->id){

           $user->description = $request->input('description');
           $user->website = $request->input('website');
           //$user->avatar = $request->input('avatar');
           $user->name = $request->input('name');
           $user->save();

           return $user;

        } else {
            //return back with error message
            return back()->with('error', 'You can only update your own profile');
        }

    }

}
