<?php

namespace App\User\Interface\Http\Controller;

use App\User\Application\UseCase\RegisterUser\RegisterUserCommand;
use App\User\Application\UseCase\RegisterUser\RegisterUserUseCase;
use App\User\Interface\Http\DTO\UserRegistrationDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserRegistrationController extends AbstractController
{
    #[Route('/api/user/register', name: 'user.register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload(validationFailedStatusCode: 422)] UserRegistrationDTO $dto,
        RegisterUserUseCase $registerUserUseCase
    ): Response {
        $command = new RegisterUserCommand(
            name: $dto->name,
            email: $dto->email,
            password: $dto->password,
        );

        return $this->json($registerUserUseCase->execute($command)->toArray(), 201);
    }
}
