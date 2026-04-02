<?php

namespace App\Tests\Repository;

use App\Repository\LessonRepository;
use PHPUnit\Framework\TestCase;

class LessonRepositoryTest extends TestCase
{
    public function testRepositoryClassExists(): void
    {
        $this->assertTrue(class_exists(LessonRepository::class));
    }
}