<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\RegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationServiceTest extends TestCase
{
    public function testRegisterUser(): void
    {
        $hasher = $this->createMock(UserPasswordHasherInterface::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $user = new User();

        $hasher->method('hashPassword')
            ->willReturn('hashed_password');

        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');

        $service = new RegistrationService($hasher, $em);

        $result = $service->register($user, 'plainPassword');

        $this->assertEquals('hashed_password', $result->getPassword());
        $this->assertFalse($result->isVerified());
        $this->assertNotNull($result->getEmailVerificationToken());
    }
}