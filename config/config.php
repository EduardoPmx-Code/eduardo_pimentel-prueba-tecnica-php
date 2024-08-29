<?php
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//$dotenv->load();

return [
    'database' => [
        'host' => getenv('DATABASE_HOST'),
        'port' => getenv('DATABASE_PORT'),
        'user' => getenv('DATABASE_USER'),
        'password' => getenv('DATABASE_PASSWORD'),
        'dbname' => getenv('DATABASE_NAME')
    ]
];