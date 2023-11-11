<?php

namespace App\Http\Controllers;

use App\Actions\HandleLike;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, HandleLike $handleLike) {

        return $handleLike->handle($request->input('status_id'));

    }

    public function dislike(Request $request) {

    }
}
