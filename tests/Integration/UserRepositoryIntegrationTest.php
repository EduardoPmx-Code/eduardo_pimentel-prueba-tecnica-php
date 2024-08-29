<?php

use PHPUnit\Framework\TestCase;
use Repositories\UserRepository;
use Model\User;
use PDO;

class UserRepositoryIntegrationTest extends TestCase
{
    private PDO $pdo;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp(); // Llama al método setUp de la clase base, si es necesario

        // Configuración de la base de datos en memoria
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            email TEXT UNIQUE,
            password TEXT,
            is_active BOOLEAN
        )");

        // Inicializa el repositorio de usuarios con la conexión PDO
        $this->userRepository = new UserRepository($this->pdo);
    }

    public function testSaveAndFindUser()
    {
        // Crea un nuevo usuario
        $user = new User(0, 'Jane Doe', 'jane.doe@example.com', 'password', true);

        // Guarda el usuario en la base de datos
        $this->userRepository->save($user);

        // Asume que el ID es auto-incrementado y será 1
        $savedUser = $this->userRepository->findById(1);

        // Verifica que el usuario guardado sea una instancia de la clase User
        $this->assertInstanceOf(User::class, $savedUser);
        // Verifica que el nombre y el correo electrónico del usuario sean correctos
        $this->assertEquals('Jane Doe', $savedUser->getName());
        $this->assertEquals('jane.doe@example.com', $savedUser->getEmail());
    }

    public function testWhenUserIsNotFoundById()
    {
        // Busca un usuario con un ID que no existe
        $user = $this->userRepository->findById(999); // ID no existente

        // Verifica que el resultado sea nulo cuando el usuario no existe
        $this->assertNull($user);
    }
}
