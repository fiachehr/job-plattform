<?php

namespace App\User\Interface\Http\Response;

final class ErrorResponse
{
    /**
     * @param array<string, list<string>> $errors
     */
    public function __construct(
        public readonly string $message,
        public readonly array $errors = [],
    ) {}

    /**
     * @return array{message: string, errors?: array<string, list<string>>}
     */
    public function toArray(): array
    {
        $payload = ['message' => $this->message];

        if ($this->errors !== []) {
            $payload['errors'] = $this->errors;
        }

        return $payload;
    }
}
