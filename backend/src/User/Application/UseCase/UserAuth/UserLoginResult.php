<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\UserAuth;

final class UserLoginResult
{

    public function __construct(
        public readonly string $token
    ) {}
}
