<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class NotificationController extends Controller
{
    public function show() {

        return Inertia::render('Notifications', [

            "color" => "red"

        ]);

    }
}
