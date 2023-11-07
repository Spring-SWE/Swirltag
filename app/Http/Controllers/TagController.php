<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function fetch(Request $request)
    {
        $searchTerm = $request->input('searchTerm', '');

        // Fetch the tags that match the search term from the database
        $tags = \App\Models\Tag::where('name', 'like', '%' . $searchTerm . '%')
                ->limit(5)->get();

        // Return the tags as a JSON response
        return response()->json($tags);
    }

}
