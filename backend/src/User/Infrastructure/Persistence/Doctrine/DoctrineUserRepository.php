<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


final class DoctrineUserRepository implements UserRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly JWTTokenManagerInterface $jwt,
    ) {}

    public function findOneByEmail(string $email): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }

    public function findOneByUUID(string $id): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['id' => $id]);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function login(User $user): string
    {
        return $this->jwt->create($user);
    }
}
