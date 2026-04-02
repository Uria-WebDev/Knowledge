<?php

namespace App\Tests\Entity;

use App\Entity\Cursus;
use App\Entity\Lesson;
use PHPUnit\Framework\TestCase;

class CursusTest extends TestCase
{
    public function testAddLesson(): void
    {
        $cursus = new Cursus();
        $lesson = new Lesson();

        $cursus->addLesson($lesson);

        $this->assertCount(1, $cursus->getLessons());
    }

    public function testRemoveLesson(): void
    {
        $cursus = new Cursus();
        $lesson = new Lesson();

        $cursus->addLesson($lesson);
        $cursus->removeLesson($lesson);

        $this->assertCount(0, $cursus->getLessons());
    }
}