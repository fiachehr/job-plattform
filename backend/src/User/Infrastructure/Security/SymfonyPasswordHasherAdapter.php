<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security;

use App\User\Application\Port\PasswordHasherGateway;
use App\User\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class SymfonyPasswordHasherAdapter implements PasswordHasherGateway
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function hash(User $user, string $plainPassword, ?string $driver = null): string
    {
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }

    public function isPasswordValid(User $user, string $plainPassword, ?string $driver = null): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $plainPassword);
    }
}
