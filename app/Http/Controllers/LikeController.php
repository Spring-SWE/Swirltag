<?php

namespace App\Http\Controllers;

use App\Actions\HandleLike;
use App\Actions\HandleDislike;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, HandleLike $handleLike) {

        return $handleLike->handle($request->input('status_id'), 1);

    }

    public function dislike(Request $request, HandleDislike $handleDislike) {

        return $handleDislike->handle($request->input('status_id'), -1);

    }
}
