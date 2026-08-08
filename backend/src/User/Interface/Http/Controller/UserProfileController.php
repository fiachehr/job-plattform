<?php

declare(strict_types=1);

namespace App\User\Interface\Http\Controller;

use App\User\Application\UseCase\UserProfile\UserProfileUseCase;
use App\User\Interface\Http\DTO\UserProfileDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

use Symfony\Component\Routing\Attribute\Route;

final class UserProfileController extends AbstractController
{

    #[Route('/api/user/profile', name: 'user.profile', methods: ['PUT', 'PATCH'])]
    public function profile(
        #[MapRequestPayload(validationFailedStatusCode: 422)] UserProfileDTO $dto,
        UserProfileUseCase $userProfileUseCase,
        Request $request
    ): Response {

        return $this->json(
            $userProfileUseCase->execute(
                $dto,
                $request->headers->get('Authorization')
            )
        );
    }
}
