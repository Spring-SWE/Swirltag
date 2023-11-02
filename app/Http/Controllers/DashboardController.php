<?php

namespace App\Http\Controllers;

use App\Actions\GetPopularThreads;
use Inertia\Response;
use Inertia\Inertia;


class DashboardController extends Controller
{
    /**
     * Show the popular threads on the Dashboard.
     */
    public function showDashboardThreads(GetPopularThreads $getThreads): Response
    {
         return Inertia::render('Dashboard', [

             'threads' => $getThreads->handle(),

         ]);
    }
}
