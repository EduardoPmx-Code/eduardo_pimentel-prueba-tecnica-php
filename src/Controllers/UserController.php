<?php

namespace Controllers;

use DTO\UserDTO;
use UseCases\CreateUserUseCase;
use UseCases\UpdateUserUseCase;
use UseCases\DeleteUserUseCase;
use UseCases\GetAllUsersUseCase;
use UseCases\GetUserByIdUseCase;
use Repositories\UserRepositoryInterface;

class UserController
{
    private CreateUserUseCase $createUserUseCase;
    private UpdateUserUseCase $updateUserUseCase;
    private DeleteUserUseCase $deleteUserUseCase;
    private GetAllUsersUseCase $getAllUsersUseCase;
    private GetUserByIdUseCase $getUserByIdUseCase;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        CreateUserUseCase $createUserUseCase,
        UpdateUserUseCase $updateUserUseCase,
        DeleteUserUseCase $deleteUserUseCase,
        GetAllUsersUseCase $getAllUsersUseCase,
        GetUserByIdUseCase $getUserByIdUseCase,
        UserRepositoryInterface $userRepository
    ) {
        $this->createUserUseCase = $createUserUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
        $this->getAllUsersUseCase = $getAllUsersUseCase;
        $this->getUserByIdUseCase = $getUserByIdUseCase;
        $this->userRepository = $userRepository;
    }

    public function createUser(array $requestData): array
    {
        // Validar que los campos requeridos están presentes y no vacíos
        if (empty($requestData['name']) || empty($requestData['email']) || empty($requestData['password'])) {
            throw new \InvalidArgumentException("Name, email, and password are required.");
        }

        // Validar el formato del correo electrónico
        if (!filter_var($requestData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format.");
        }

        $userDTO = new UserDTO($requestData['name'], $requestData['email'], $requestData['password']);
        return $this->createUserUseCase->execute($userDTO);
    }

    public function updateUser(array $requestData, int $id): array
    {
    try {
        // Validar que el ID es un número entero positivo
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid user ID.');
        }

        // Crear el DTO para la actualización
        $updateUserDTO = new \DTO\UpdateUserDTO(
            $requestData['name'] ?? null,
            $requestData['email'] ?? null,
            $requestData['password'] ?? null,
            $requestData['is_active'] ?? true,
            $id
        );

        $result = $this->updateUserUseCase->execute($id, $updateUserDTO);

        return $result;
        } catch (\InvalidArgumentException $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 400];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
    }  
    }





    public function deleteUser($id): array
    {
    // Verificar que el ID sea un número entero y positivo
    if (!is_numeric($id) || $id <= 0) {
        throw new \Exceptions\HttpException("Invalid user ID.", 400); // Excepción HTTP personalizada con código 400 (Bad Request)
    }

    try {
        // Ejecutar la lógica de eliminación del usuario
        return $this->deleteUserUseCase->execute((int)$id);
    } catch (\Exception $e) {
        // Captura cualquier excepción y arroja una excepción HTTP con un código de error 500
        throw new \Exceptions\HttpException("An error occurred while deleting the user.", 500);
    }
    }


    public function getAllUsers(): array
    {
        return $this->getAllUsersUseCase->execute();
    }

    public function getUserById(int $id): array
    {
        try {
            $result = $this->getUserByIdUseCase->execute($id);

            return $result;
        } catch (\Exception $e) {
            return  [$e->getMessage()];
        }
    }
}
