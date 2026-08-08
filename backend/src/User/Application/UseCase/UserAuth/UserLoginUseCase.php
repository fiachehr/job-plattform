<?php

declare(strict_types=1);

namespace App\User\Application\UseCase\UserAuth;

use App\User\Interface\Http\DTO\UserLoginDTO;
use App\User\Domain\Exception\EmailNotExistException;
use App\User\Domain\Exception\WrongPasswordException;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\Security\SwitchablePasswordHasherGateway;


final class UserLoginUseCase
{

    public function __construct(
        private SwitchablePasswordHasherGateway $passwordHasher,
        private UserRepository $userRepository
    ) {}

    public function execute(UserLoginDTO $dto): UserLoginResult
    {
        $user = $this->userRepository->findOneByEmail($dto->email);
        if (!$user) {
            throw new EmailNotExistException;
        }

        $isPasswordValid = $this->passwordHasher->isPasswordValid($user, $dto->password);
        if (!$isPasswordValid) {
            throw new WrongPasswordException;
        }
        return new UserLoginResult(
            token: $this->userRepository->login($user)
        );
    }
}
