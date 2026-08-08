<?php

namespace App\User\Application\UseCase\RegisterUser;

final class RegisterUserResult
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
    ) {}

    /**
     * @return array{id: string, name: string, email: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
