<?php

use Controllers\UserController;
use Controllers\StatusServerController;

return [
    'GET' => [
        '/user' => [UserController::class, 'getAllUsers'],
        '/user/{id}' => [UserController::class, 'getUserById'],
        '/status' => [StatusServerController::class, 'checkStatus']
    ],
    'POST' => [
        '/user' => [UserController::class, 'createUser']
    ],
    'PUT' => [
        '/user/{id}' => [UserController::class, 'updateUser']
    ],
    'DELETE' => [
        '/user/{id}' => [UserController::class, 'deleteUser']
    ],
];