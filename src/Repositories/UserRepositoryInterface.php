<?php

namespace Repositories;

use Model\User;

interface UserRepositoryInterface
{
    /**
     * Guarda un usuario en el repositorio.
     *
     * @param User $user El usuario a guardar.
     * @return void
     */
    public function save(User $user): void;

    /**
     * Actualiza un usuario en el repositorio.
     *
     * @param User $user El usuario a actualizar.
     * @return void
     */
    public function update(User $user): void;

    /**
     * Elimina un usuario del repositorio.
     *
     * @param User $user El usuario a eliminar.
     * @return void
     */
    public function delete(User $user): void;

    /**
     * Busca un usuario por su ID.
     *
     * @param int $id El ID del usuario.
     * @return User|null El usuario encontrado o null si no existe.
     */
    public function findById(int $id): ?User;

    /**
     * Obtiene todos los usuarios del repositorio.
     *
     * @return User[] Un array de usuarios.
     */
    public function findAll(): array;
}
