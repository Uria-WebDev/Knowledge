<?php

namespace App\Tests\Controller;

use App\Controller\RegistrationController;
use PHPUnit\Framework\TestCase;

class RegistrationControllerTest extends TestCase
{
    public function testControllerExists(): void
    {
        $controller = new RegistrationController();
        $this->assertInstanceOf(RegistrationController::class, $controller);
    }
}