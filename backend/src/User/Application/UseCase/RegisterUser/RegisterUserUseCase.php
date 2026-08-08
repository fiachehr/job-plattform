<?php

namespace App\User\Application\UseCase\RegisterUser;

use App\User\Application\Port\PasswordHasherGateway;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\EmailAlreadyExistsException;
use App\User\Domain\Repository\UserRepository;

final class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordHasherGateway $passwordHasher,
    ) {}

    public function execute(RegisterUserCommand $command): RegisterUserResult
    {
        $existingUser = $this->userRepository->findOneByEmail($command->email);

        if ($existingUser !== null) {
            throw new EmailAlreadyExistsException();
        }

        $user = new User();
        $user->setName($command->name);
        $user->setEmail($command->email);
        $user->setPassword($this->passwordHasher->hash($user, $command->password));

        $this->userRepository->save($user);

        return new RegisterUserResult(
            id: (string) $user->getId(),
            name: $user->getName(),
            email: $user->getEmail(),
        );
    }
}
