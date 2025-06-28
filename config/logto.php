<?php

return [
    'endpoint' => env('LOGTO_ENDPOINT', 'https://sso.denpasarkota.go.id'),
    'app_id' => env('LOGTO_APP_ID'),
    'app_secret' => env('LOGTO_APP_SECRET'),
    'redirect_uri' => env('LOGTO_REDIRECT_URI', 'http://localhost:8000/callback'),
    'scopes' => ['all', 'openid', 'profile', 'email'],
];