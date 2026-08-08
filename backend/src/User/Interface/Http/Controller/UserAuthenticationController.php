<?php

declare(strict_types=1);

namespace App\User\Interface\Http\Controller;

use App\User\Application\UseCase\UserAuth\UserLoginUseCase;
use App\User\Interface\Http\DTO\UserLoginDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserAuthenticationController extends AbstractController
{
    #[Route('/api/user/login', name: 'user.login', methods: ['POST'])]
    public function login(
        #[MapRequestPayload(validationFailedStatusCode: 422)] UserLoginDTO $dto,
        UserLoginUseCase $userLoginUseCase
    ): Response {
        return $this->json($userLoginUseCase->execute($dto));
    }
}
