<?php

namespace UseCases;

use Repositories\UserRepositoryInterface;

class DeleteUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Ejecuta el caso de uso para eliminar un usuario.
     *
     * @param int $userId ID del usuario a eliminar.
     * @return array Respuesta de éxito o error.
     */
    public function execute(int $userId): array
    {
        $user = $this->userRepository->findById($userId);

        if ($user === null) {
            return [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }

        $this->userRepository->delete($user);

        return [
            'status' => 'success',
            'message' => 'User deleted successfully'
        ];
    }
}
