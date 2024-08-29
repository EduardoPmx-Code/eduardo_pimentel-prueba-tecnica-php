<?php

use PHPUnit\Framework\TestCase;
use Repositories\UserRepositoryInterface;
use UseCases\GetUserByIdUseCase;
use Model\User;
use PHPUnit\Framework\MockObject\MockObject;

class GetUserByIdUseCaseTest extends TestCase
{
    /**
     * @var UserRepositoryInterface|MockObject
     */
    private UserRepositoryInterface|MockObject $userRepositoryMock;

    private GetUserByIdUseCase $getUserByIdUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->getUserByIdUseCase = new GetUserByIdUseCase($this->userRepositoryMock);
    }

    public function testGetUserByIdSuccessfully()
    {
        $user = new User(1, 'John Doe', 'john.doe@example.com', 'password', true);

        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(1))
            ->willReturn($user);

        $result = $this->getUserByIdUseCase->execute(1);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'is_active' => true
        ], $result['data']);
    }

    public function testGetUserByIdNotFound()
    {
        $this->userRepositoryMock->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(999))
            ->willReturn(null);

        $result = $this->getUserByIdUseCase->execute(999);

        $this->assertEquals('error', $result['status']);
        $this->assertEquals('User not found', $result['message']);
    }
}
