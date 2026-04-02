<?php

namespace App\Tests\Entity;

use App\Entity\Theme;
use App\Entity\Cursus;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    public function testAddCursus(): void
    {
        $theme = new Theme();
        $cursus = new Cursus();

        $theme->addCursus($cursus);

        $this->assertCount(1, $theme->getCursus());
    }

    public function testRemoveCursus(): void
    {
        $theme = new Theme();
        $cursus = new Cursus();

        $theme->addCursus($cursus);
        $theme->removeCursus($cursus);

        $this->assertCount(0, $theme->getCursus());
    }
}