<?php

namespace App\Actions;

use App\Models\Tag;

class ProcessHashtags
{
    public function __invoke($text)
    {
        preg_match_all('/#(\w+)/', $text, $matches);
        $hashtags = $matches[1];

        foreach ($hashtags as $hashtag) {
            // Normalize the hashtag to lowercase for consistency
            $hashtag = strtolower($hashtag);

            // check if the hashtag exists, and if not, create it
            Tag::firstOrCreate(['name' => $hashtag]);
        }
    }
}
