<?php

namespace UseCases;

use DTO\UpdateUserDTO;
use Repositories\UserRepositoryInterface;
class UpdateUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Actualiza un usuario en la base de datos.
     *
     * @param int $userId ID del usuario a actualizar.
     * @param UpdateUserDTO $userDTO Datos actualizados del usuario.
     * @return array Resultado de la operación.
     */
    public function execute(int $id, UpdateUserDTO $userDTO): array
    {
    // Obtener el usuario por ID
    $user = $this->userRepository->findById($id);

    if (!$user) {
        throw new \Exception('User not found');
    }

    // Actualizar los datos del usuario si están presentes en el DTO
    if ($userDTO->getName() !== null) {
        $user->setName($userDTO->getName());
    }

    if ($userDTO->getEmail() !== null) {
        $user->setEmail($userDTO->getEmail());
    }

    // Solo actualizar la contraseña si se proporciona
    if ($userDTO->getPassword() !== null) {
        $user->setPassword($userDTO->getPassword());
    }

    if ($userDTO->getIsActive() !== null) {
        $user->setIsActive($userDTO->getIsActive());
    }

    // Guardar los cambios en el repositorio
    $this->userRepository->save($user);

        return ['status' => 'success', 'message' => 'User updated successfully'];
    }

}
