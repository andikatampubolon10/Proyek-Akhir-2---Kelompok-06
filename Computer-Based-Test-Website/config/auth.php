<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Authentication Defaults
    |---------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),  // Mendapatkan nilai default 'web' dari .env
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),  // Mendapatkan nilai default 'users' dari .env
    ],

    /*
    |---------------------------------------------------------------------------
    | Authentication Guards
    |---------------------------------------------------------------------------
    |
    | This section defines every authentication guard for your application.
    | Laravel provides a great default configuration that uses session
    | storage and the Eloquent user provider.
    |
    | Supported: "session", "api"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Tambahkan API guard (opsional)
        'api' => [
            'driver' => 'passport', // Atau 'sanctum' jika Anda menggunakan Sanctum
            'provider' => 'users',
            'hash' => true,  // Gunakan 'hash' untuk API token
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | User Providers
    |---------------------------------------------------------------------------
    |
    | This section defines how users are retrieved from your database or
    | other storage systems. The Eloquent provider is used by default,
    | but you can configure it to use other systems.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Password Reset Configuration
    |---------------------------------------------------------------------------
    |
    | These options control the behavior of Laravel's password reset functionality.
    | You can specify the table used for storing reset tokens, the provider to use,
    | and expiration time for tokens.
    |
    | The throttle setting controls how many seconds before generating another reset token.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60, // Set the expiration time for reset tokens (in minutes)
            'throttle' => 60, // Set the throttle time between attempts (in seconds)
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Password Confirmation Timeout
    |---------------------------------------------------------------------------
    |
    | Define the time duration (in seconds) before the password confirmation window expires.
    | Default is 3 hours (10800 seconds).
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800), // Default 3 hours

];
