<?php

namespace App\Http\Controllers;

use App\Actions\GetPopularStatuses;
use Inertia\Response;
use Inertia\Inertia;


class DashboardController extends Controller
{
    /**
     * Show the popular Statuses on the Dashboard.
     */
    public function show(GetPopularStatuses $getStatuses): Response
    {
         return Inertia::render('Dashboard', [

             'statuses' => $getStatuses->handle(),

         ]);
    }
}
