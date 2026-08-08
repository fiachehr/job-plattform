<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use RuntimeException;

final class EmailAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Email already exists.');
    }
}
