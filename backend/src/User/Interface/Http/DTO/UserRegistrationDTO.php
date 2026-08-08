<?php

namespace App\User\Interface\Http\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class UserRegistrationDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Email]
        #[Assert\Length(max: 180)]
        public string $email,
        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        #[Assert\Regex(pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', message: 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character')]
        public string $password,
    ) {}
}
