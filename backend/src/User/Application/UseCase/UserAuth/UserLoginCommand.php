<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\UserAuth;

final class UserLoginCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}
}
