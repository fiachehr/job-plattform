<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security;

use App\User\Application\Port\PasswordHasherGateway;
use App\User\Domain\Entity\User;
use InvalidArgumentException;

final class NativePasswordHasherAdapter implements PasswordHasherGateway
{
    public function __construct(
        private readonly string $algorithm,
    ) {}

    public function hash(User $user, string $plainPassword, ?string $driver = null): string
    {
        $algo = match ($this->algorithm) {
            'bcrypt' => PASSWORD_BCRYPT,
            'argon2i' => PASSWORD_ARGON2I,
            'argon2id' => PASSWORD_ARGON2ID,
            default => throw new InvalidArgumentException(sprintf('Unsupported native hash algorithm "%s".', $this->algorithm)),
        };

        $hashed = password_hash($plainPassword, $algo);

        if ($hashed === false) {
            throw new InvalidArgumentException('Native password hash failed.');
        }

        return $hashed;
    }

    public function isPasswordValid(User $user, string $plainPassword, ?string $driver = null): bool
    {
        return password_verify($plainPassword, $user->getPassword());
    }
}
