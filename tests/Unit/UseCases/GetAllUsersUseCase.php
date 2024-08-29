<?php

use PHPUnit\Framework\TestCase;
use Repositories\UserRepositoryInterface;
use UseCases\GetAllUsersUseCase;
use Model\User;
use PHPUnit\Framework\MockObject\MockObject;

class GetAllUsersUseCaseTest extends TestCase
{
    /**
     * @var UserRepositoryInterface|MockObject
     */
    private UserRepositoryInterface|MockObject $userRepositoryMock;

    private GetAllUsersUseCase $getAllUsersUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->getAllUsersUseCase = new GetAllUsersUseCase($this->userRepositoryMock);
    }

    public function testGetAllUsersSuccessfully()
    {
        $users = [
            new User(1, 'John Doe', 'john.doe@example.com', 'password', true),
            new User(2, 'Jane Doe', 'jane.doe@example.com', 'password', false)
        ];

        $this->userRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $result = $this->getAllUsersUseCase->execute();

        $this->assertEquals('success', $result['status']);
        $this->assertCount(2, $result['data']);
        $this->assertEquals([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'is_active' => true],
            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane.doe@example.com', 'is_active' => false]
        ], $result['data']);
    }
}
