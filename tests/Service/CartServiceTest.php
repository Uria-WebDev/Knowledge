<?php

namespace App\Tests\Service;

use App\Service\CartService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use App\Repository\CursusRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CartServiceTest extends TestCase
{
    private function getCartService(): CartService
    {
        $session = new Session(new MockArraySessionStorage());

        $request = new Request();
        $request->setSession($session);

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $cursusRepo = $this->createMock(CursusRepository::class);
        $lessonRepo = $this->createMock(LessonRepository::class);
        $security = $this->createMock(Security::class);

        return new CartService($requestStack, $cursusRepo, $lessonRepo, $security);
    }

    public function testAddCursus(): void
    {
        $cart = $this->getCartService();

        $result = $cart->add(1);

        $this->assertNull($result);

        $data = $cart->getCart();
        $this->assertIsArray($data);
    }

    public function testRemoveItem(): void
    {
        $cart = $this->getCartService();

        $cart->add(1);
        $cart->remove('cursus_1');

        $data = $cart->getCart();

        $this->assertEmpty($data['items']);
    }

    public function testClearCart(): void
    {
        $cart = $this->getCartService();

        $cart->add(1);
        $cart->clear();

        $data = $cart->getCart();

        $this->assertEmpty($data['items']);
    }
}