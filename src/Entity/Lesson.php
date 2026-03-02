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

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    public function __construct()
    {
        $this->cursus = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    // ID
    public function getId(): ?int
    {
        return $this->id;
    }

    // NAME
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    // TEXT
    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    // PRICE
    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;
        return $this;
    }

    // CURSUS
    /**
     * @return Collection<int, Cursus>
     */
    public function getCursus(): Collection
    {
        return $this->cursus;
    }

    public function addCursus(Cursus $cursus): self
    {
        if (!$this->cursus->contains($cursus)) {
            $this->cursus->add($cursus);
            $cursus->addLesson($this);
        }

        return $this;
    }

    public function removeCursus(Cursus $cursus): self
    {
        if ($this->cursus->removeElement($cursus)) {
            $cursus->removeLesson($this);
        }

        return $this;
    }

    // USERS
    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addLessonsBought($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeLessonsBought($this);
        }

        return $this;
    }
}