<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public Registration
    |--------------------------------------------------------------------------
    |
    | When false, /register routes are disabled. Set FNS_ALLOW_REGISTRATION=true
    | in .env only if you intentionally want open self-registration.
    |
    */
    'allow_registration' => (bool) env('FNS_ALLOW_REGISTRATION', false),

];
