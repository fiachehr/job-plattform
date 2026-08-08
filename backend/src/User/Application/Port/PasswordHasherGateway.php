<?php

namespace App\User\Application\Port;

use App\User\Domain\Entity\User;

interface PasswordHasherGateway
{
    public function hash(User $user, string $plainPassword, ?string $driver = null): string;

    public function isPasswordValid(User $user, string $plainPassword, ?string $driver = null): bool;
}
