<?php

use Pimple\Container;
use Database\DatabaseConnection;
use Repositories\UserRepository;
use Repositories\UserRepositoryInterface;
use Controllers\UserController;
use Controllers\StatusServerController;
use UseCases\CreateUserUseCase;
use UseCases\GetAllUsersUseCase;
use UseCases\UpdateUserUseCase;
use UseCases\GetUserByIdUseCase;
use UseCases\DeleteUserUseCase;

// Crea el contenedor de servicios
$container = new Container();

// Configura la conexión a la base de datos
$container['db'] = function ($c) {
    $config = require __DIR__ . '/../config/config.php';
    $dbConnection = new DatabaseConnection($config['database']);
    return $dbConnection->getConnection();
};

// Verifica la conexión a la base de datos (solo en la inicialización)
try {
    $db = $container['db'];
    // Registro en un archivo de log, por ejemplo
    error_log("Database connection is successful");
} catch (RuntimeException $e) {
    // Registro en un archivo de log
    error_log("Database connection error: " . $e->getMessage());
}

// Configura las dependencias
$container[UserRepositoryInterface::class] = function ($c) {
    return new UserRepository($c['db']);
};

$container[CreateUserUseCase::class] = function ($c) {
    return new CreateUserUseCase($c[UserRepositoryInterface::class]);
};

$container[UpdateUserUseCase::class] = function ($c) {
    return new UpdateUserUseCase($c[UserRepositoryInterface::class]);
};

$container[GetAllUsersUseCase::class] = function ($c) {
    return new GetAllUsersUseCase($c[UserRepositoryInterface::class]);
};

$container[DeleteUserUseCase::class] = function ($c) {
    return new DeleteUserUseCase($c[UserRepositoryInterface::class]);
};

$container[GetUserByIdUseCase::class] = function ($c) {
    return new GetUserByIdUseCase($c[UserRepositoryInterface::class]);
};

$container[UserController::class] = function ($c) {
    return new UserController(
        $c[CreateUserUseCase::class],
        $c[UpdateUserUseCase::class],
        $c[DeleteUserUseCase::class],
        $c[GetAllUsersUseCase::class],
        $c[GetUserByIdUseCase::class],
        $c[UserRepositoryInterface::class]
    );
};

$container[StatusServerController::class] = function ($c) {
    return new StatusServerController();
};

// Devuelve el contenedor
return $container;
