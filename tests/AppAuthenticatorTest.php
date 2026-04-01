<?php

namespace App\Tests\Security;

use App\Security\AppAuthenticator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class AppAuthenticatorTest extends TestCase
{
    public function testAuthenticate(): void
    {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);

        $authenticator = new AppAuthenticator($urlGenerator);

        $request = new Request([], [
            '_username' => 'test@example.com',
            '_password' => 'password123',
            '_csrf_token' => 'token'
        ]);

        $request->setSession(new Session(new MockArraySessionStorage()));

        $passport = $authenticator->authenticate($request);

        $this->assertInstanceOf(Passport::class, $passport);
    }
}