<?php

use PHPUnit\Framework\TestCase;
use Repositories\UserRepositoryInterface;
use UseCases\DeleteUserUseCase;
use Model\User;
use PHPUnit\Framework\MockObject\MockObject;

class DeleteUserUseCaseTest extends TestCase
{
    /**
     * @var UserRepositoryInterface|MockObject
     */
    private UserRepositoryInterface|MockObject $userRepositoryMock;

    private DeleteUserUseCase $deleteUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->deleteUserUseCase = new DeleteUserUseCase($this->userRepositoryMock);
    }

    public function testDeleteUserSuccessfully()
    {
        $user = new User(1, 'John Doe', 'john.doe@example.com', 'password', true);

        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(1))
            ->willReturn($user);

        $this->userRepositoryMock->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($user));

        $result = $this->deleteUserUseCase->execute(1);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('User deleted successfully', $result['message']);
    }

    public function testDeleteNonExistentUser()
    {
        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(999))
            ->willReturn(null);

        $result = $this->deleteUserUseCase->execute(999);

        $this->assertEquals('error', $result['status']);
        $this->assertEquals('User not found', $result['message']);
    }
}
