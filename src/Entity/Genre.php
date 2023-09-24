<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[ORM\Table(name: 'genres')]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idGenre')]
    private ?int $idGenre = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity:Book::class, mappedBy:"genre", fetch:"LAZY")]
    // La variable de la relation (Foreign Key)
    private $books;

    public function getIdGenre(): ?int
    {
        return $this->idGenre;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBooks() : Collection {
        return $this->books;
    }
}
