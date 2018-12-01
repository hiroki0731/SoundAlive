<?php

/**
 * API KEY
 */

return [

    'google_map' => env('GOOGLE_MAP_KEY', ''),

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'client_id_access_token' => env('TWITTER_CLIENT_ID_ACCESS_TOKEN'),
        'client_id_access_token_secret' => env('TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET')
    ],

];
