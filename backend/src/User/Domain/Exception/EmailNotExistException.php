<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class EmailNotExistException extends UnauthorizedHttpException
{
    public function __construct()
    {
        parent::__construct('Login', 'User is not existed');
    }
}
