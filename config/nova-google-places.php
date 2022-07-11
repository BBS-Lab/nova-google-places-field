<?php

return [
    'script_url' => env(
        'GOOGLE_PLACES_SCRIPT_URL',
        'https://maps.googleapis.com/maps/api/js?key=:YOUR_API_KEY&libraries=places'
    ),
    'api_key' => env('GOOGLE_PLACES_API_KEY'),
];
