<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security;

use App\User\Application\Port\PasswordHasherGateway;
use App\User\Domain\Entity\User;

final class SwitchablePasswordHasherGateway implements PasswordHasherGateway
{
    public function __construct(
        private readonly SymfonyPasswordHasherAdapter $symfonyHasher,
        private readonly NativePasswordHasherAdapter $nativeHasher,
        private readonly string $activeDriver,
    ) {}

    public function hash(User $user, string $plainPassword, ?string $driver = null): string
    {
        return $this->resolveHasher($driver)->hash($user, $plainPassword);
    }

    public function isPasswordValid(User $user, string $plainPassword, ?string $driver = null): bool
    {
        return $this->resolveHasher($driver)->isPasswordValid($user, $plainPassword);
    }

    private function resolveHasher(?string $driver = null): PasswordHasherGateway
    {
        $resolvedDriver = $driver ?? $this->activeDriver;

        return match ($resolvedDriver) {
            'symfony' => $this->symfonyHasher,
            'native' => $this->nativeHasher,
            default => throw new \InvalidArgumentException(
                sprintf(
                    'Unsupported password hasher driver "%s". Use "symfony" or "native".',
                    $resolvedDriver
                )
            ),
        };
    }
}
