<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Cursus::class, inversedBy: 'themes')]
    private Collection $cursus;

    public function __construct()
    {
        $this->cursus = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeCursus(Cursus $cursus): self
    {
        $this->cursus->removeElement($cursus);
        return $this;
    }
}