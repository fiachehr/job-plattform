<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\UserProfile;

use App\User\Domain\Repository\UserRepository;
use App\User\Interface\Http\DTO\UserProfileDTO;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class UserProfileUseCase
{

    public function __construct(
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $jwt
    ) {}

    public function execute(UserProfileDTO $dto, string $token)
    {
        $currentUser = $this->jwt->parse(str_replace('Bearer ', '', $token));
        $user = $this->userRepository->findOneByUUID($dto->id);

        if ($currentUser['username'] !== $user->getEmail()) {
            return;
        }

        if ($user->getEmail() != $dto->email) {
            $isEmailExist = $this->userRepository->findOneByEmail($dto->email);
            if ($isEmailExist) {
                return;
            }
        }

        $user->setEmail($dto->email);
        $user->setName($dto->name);
        $this->userRepository($user);
    }
}
