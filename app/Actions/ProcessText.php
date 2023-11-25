<?php
namespace App\Actions;

use App\Models\Tag;
use App\Models\User;

class ProcessText
{
    public static function linkify($text)
    {
        // Linkify hashtags
        $text = preg_replace_callback('/(?<!\w)#(\w+)/', function ($matches) {
            $hashtag = $matches[1];
            if (Tag::where('name', $hashtag)->exists()) {
                return '<a class="mention" href="/hashtag/' . $hashtag . '">#' . $hashtag . '</a>';
            }
            return $matches[0]; // Return the original text if hashtag doesn't exist
        }, $text);

        // Linkify mentions
        $text = preg_replace_callback('/(?<!\w)@(\w+)/', function ($matches) {
            $username = $matches[1];
            if (User::where('name', $username)->exists()) {
                return '<a class="mention" href="/' . $username . '">@' . $username . '</a>';
            }
            return $matches[0]; // Return the original text if user doesn't exist
        }, $text);

        // Normalize spaces around links
        $text = preg_replace('/\s*(<a class="mention"[^>]*>.*?<\/a>)\s*/', ' $1 ', $text);

        // Remove extra spaces
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }
}
