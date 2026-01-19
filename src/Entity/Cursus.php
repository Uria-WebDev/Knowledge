<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Cursus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Theme::class, mappedBy: 'cursus')]
    private Collection $themes;

    #[ORM\ManyToMany(targetEntity: Lesson::class, inversedBy: 'cursus')]
    private Collection $lessons;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->lessons = new ArrayCollection();
    }
}