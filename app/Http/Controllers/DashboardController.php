<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Actions\GetPopularStatuses;
use Illuminate\Http\Request;
use Inertia\Inertia;



class DashboardController extends Controller
{
    /**
     * Show the popular Statuses on the Dashboard.
     */
    public function show(GetPopularStatuses $getStatuses, Request $request)
    {
        if($request->wantsJson()) {

            return StatusResource::collection($getStatuses->handle())->response()->getData(true);

         }

         return Inertia::render('Dashboard', [

             'statuses' => StatusResource::collection($getStatuses->handle()),

         ]);

    }
}
