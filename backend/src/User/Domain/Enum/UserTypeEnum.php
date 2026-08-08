<?php

namespace App\User\Domain\Enum;

enum UserTypeEnum: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case AGENT = 'agent';
}
