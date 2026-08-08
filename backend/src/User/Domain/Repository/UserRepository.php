<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;

interface UserRepository
{
    public function findOneByEmail(string $email): ?User;

    public function findOneByUUID(string $id): ?User;

    public function save(User $user): void;

    public function login(User $user): string;
}
