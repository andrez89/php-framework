<?php

return [
    'database' => [
        'name' => 'dbname',
        'username' => 'root',
        'password' => 'password',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    'server' => [
        'title' => 'Hello',
        'url' => 'http://domain.it',
        "dir" => "",
        "SSL" => true,
        "error_reporting" => E_ALL,
        "display_errors" => 1,
        "server" => "local",
        "mail" => true
    ]
];
