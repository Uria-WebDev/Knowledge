<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class RegistrationService
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $em
    ) {}

    public function register(User $user, string $plainPassword): User
    {
        $hashedPassword = $this->hasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $token = Uuid::v4()->toRfc4122();
        $user->setEmailVerificationToken($token);
        $user->setIsVerified(false);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}