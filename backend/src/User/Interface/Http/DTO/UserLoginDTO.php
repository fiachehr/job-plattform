<?php

declare(strict_types=1);

namespace App\User\Interface\Http\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class UserLoginDTO
{
    public function __construct(
        #[Assert\Email]
        public string $email,
        #[Assert\Length(min: 8)]
        #[Assert\Regex(pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', message: 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character')]
        public string $password
    ) {}
}
