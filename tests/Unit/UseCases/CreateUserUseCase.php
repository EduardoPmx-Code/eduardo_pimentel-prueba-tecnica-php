<?php

use PHPUnit\Framework\TestCase;
use Repositories\UserRepositoryInterface;
use UseCases\CreateUserUseCase;
use DTO\UserDTO;
use Model\User;
use PHPUnit\Framework\MockObject\MockObject;

class CreateUserUseCaseTest extends TestCase
{
    /**
     * @var UserRepositoryInterface|MockObject
     */
    private UserRepositoryInterface|MockObject $userRepositoryMock;

    private CreateUserUseCase $createUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        // Crear un mock para UserRepositoryInterface
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        // Instanciar CreateUserUseCase con el mock
        $this->createUserUseCase = new CreateUserUseCase($this->userRepositoryMock);
    }

    public function testExecuteSuccess()
    {
        $userDTO = new UserDTO('John Doe', 'john.doe@example.com', 'securepassword');

        // Esperar que el método save sea llamado una vez con una instancia de User
        $this->userRepositoryMock->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        // Ejecutar el caso de uso
        $result = $this->createUserUseCase->execute($userDTO);

        // Verificar que el resultado sea el esperado
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('User created successfully', $result['message']);
    }
}
