<?php

namespace UseCases;

use Repositories\UserRepositoryInterface;

class GetAllUsersUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array
    {
        $users = $this->userRepository->findAll();

        return [
            'status' => 'success',
            'data' => array_map(function($user) {
                return [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'is_active' => $user->getIsActive()
                ];
            }, $users)
        ];
    }
}
