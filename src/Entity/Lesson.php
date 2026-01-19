<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\ManyToMany(targetEntity: Cursus::class, mappedBy: 'lessons')]
    private Collection $cursus;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'lessonsBought')]
    private Collection $users;

    public function __construct()
    {
        $this->cursus = new ArrayCollection();
        $this->users = new ArrayCollection();
    }
}