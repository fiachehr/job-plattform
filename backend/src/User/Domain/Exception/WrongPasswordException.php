<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class WrongPasswordException extends UnauthorizedHttpException
{
    public function __construct()
    {
        parent::__construct('Bearer', 'Wrong Password');
    }
}
