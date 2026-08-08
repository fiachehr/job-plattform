<?php

declare(strict_types=1);

namespace App\User\Interface\Http\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserProfileDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $id,
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Email]
        #[Assert\Length(max: 180)]
        public string $email
    ) {}
}
