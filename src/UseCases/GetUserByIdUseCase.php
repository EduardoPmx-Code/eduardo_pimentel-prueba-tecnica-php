<?php

namespace UseCases;

use Repositories\UserRepositoryInterface;
use Model\User;

class GetUserByIdUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $id): array
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'is_active' => $user->getIsActive()
            ]
        ];
    }
}
