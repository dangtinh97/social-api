<?php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'migrations' => 'migrations',
    'connections' => [

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'port'      => env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'strict'    => env('DB_STRICT_MODE', false),
        ],
    ]
];
