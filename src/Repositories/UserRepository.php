<?php

namespace Repositories;

use Repositories\UserRepositoryInterface;
use Model\User;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(User $user): void
    {
    try {
        $isNewUser = ($user->getId() === 0);
        $email = $user->getEmail();
        $password = $user->getPassword();
        $isActive = $user->getIsActive();

        // Verifica si el correo electrónico ya existe
        if ($isNewUser) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                throw new \Exception("El correo electrónico ya está en uso.");
            }
        } else {
            // Solo verifica la unicidad si el correo electrónico ha cambiado
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $user->getId()]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                throw new \Exception("El correo electrónico ya está en uso.");
            }
        }

        // Realiza la operación de insertar o actualizar
        if ($isNewUser) {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, password, is_active) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user->getName(), $email, password_hash($password, PASSWORD_BCRYPT), $isActive ? 'TRUE' : 'FALSE']);
            $user->setId($this->db->lastInsertId());
        } else {
            $updateFields = [
                'name' => $user->getName(),
                'email' => $email,
                'is_active' => $isActive ? 'TRUE' : 'FALSE',
            ];

            if ($password !== null) {
                $updateFields['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $setClause = implode(', ', array_map(fn($field) => "$field = ?", array_keys($updateFields)));
            $stmt = $this->db->prepare("UPDATE users SET $setClause WHERE id = ?");

            $updateValues = array_values($updateFields);
            $updateValues[] = $user->getId();
            $stmt->execute($updateValues);
        }
    } catch (\PDOException $e) {
        error_log("PDOException: " . $e->getMessage());
        throw new \Exception("Error en la base de datos. Por favor, inténtelo de nuevo.");
    } catch (\Exception $e) {
        error_log("Exception: " . $e->getMessage());
        throw $e;
    }
}

    public function update(User $user): void
    {
        $this->save($user);
    }

    public function delete(User $user): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user->getId()]);
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                (int)$data['id'],
                $data['name'],
                $data['email'],
                $data['password'],
                (bool)$data['is_active']
            );
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($data as $row) {
            $users[] = new User(
                (int)$row['id'],
                $row['name'],
                $row['email'],
                $row['password'],
                (bool)$row['is_active']
            );
        }

        return $users;
    }
}
