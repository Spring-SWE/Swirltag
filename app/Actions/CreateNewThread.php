<?php
namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Thread;

class CreateNewThread {

    public function handle(Request $request) {

        return Thread::create([

            'body' => $request->input('body'),

            'user_id' => $request->user()->id,

        ]);
    }
}
