<?php

namespace App\Entity;

use App\Repository\RotorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RotorRepository::class)]
class Rotor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 26)]
    private ?string $permutationsList = null;

    #[ORM\Column]
    private ?int $encoche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPermutationsList(): ?string
    {
        return $this->permutationsList;
    }

    public function setPermutationsList(string $permutationsList): self
    {
        $this->permutationsList = $permutationsList;

        return $this;
    }

    public function getEncoche(): ?int
    {
        return $this->encoche;
    }

    public function setEncoche(int $encoche): self
    {
        $this->encoche = $encoche;

        return $this;
    }


}
