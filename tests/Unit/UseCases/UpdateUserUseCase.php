<?php

use PHPUnit\Framework\TestCase;
use Repositories\UserRepositoryInterface;
use UseCases\UpdateUserUseCase;
use Model\User;
use DTO\UpdateUserDTO;
use PHPUnit\Framework\MockObject\MockObject;

class UpdateUserUseCaseTest extends TestCase
{
    /**
     * @var UserRepositoryInterface|MockObject
     */
    private UserRepositoryInterface|MockObject $userRepositoryMock;

    private UpdateUserUseCase $updateUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->updateUserUseCase = new UpdateUserUseCase($this->userRepositoryMock);
    }

    public function testUpdateUserSuccessfully()
    {
        $user = new User(1, 'John Doe', 'john.doe@example.com', 'password', true);
        $userDTO = new UpdateUserDTO('John Smith', 'john.smith@example.com', 'newpassword', true);
        
        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(1))
            ->willReturn($user);

        $this->userRepositoryMock->expects($this->once())
            ->method('save')
            ->with($this->callback(function (User $user) {
                return $user->getName() === 'John Smith' && $user->getEmail() === 'john.smith@example.com';
            }));

        $result = $this->updateUserUseCase->execute(1, $userDTO);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('User updated successfully', $result['message']);
    }

    public function testUpdateNonExistentUser()
    {
        $userDTO = new UpdateUserDTO('John Smith', null, null, null);

        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(999))
            ->willReturn(null);

        $result = $this->updateUserUseCase->execute(999, $userDTO);

        $this->assertEquals('error', $result['status']);
        $this->assertEquals('User not found', $result['message']);
    }
}
