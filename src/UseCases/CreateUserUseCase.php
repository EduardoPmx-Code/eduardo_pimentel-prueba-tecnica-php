<?php

namespace UseCases;

use DTO\UserDTO;
use Repositories\UserRepositoryInterface;
use Model\User;

class CreateUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserDTO $userDTO): array
    {
        $user = new User(
            0,
            $userDTO->getName(),
            $userDTO->getEmail(),
            $userDTO->getPassword()
        );

        $this->userRepository->save($user);

        return [
            'status' => 'success',
            'message' => 'User created successfully'
        ];
    }
}
