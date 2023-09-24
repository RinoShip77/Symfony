<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name: 'authors')]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idAuthor')]
    private ?int $idAuthor = null;

    #[ORM\Column(name: 'firstName', length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(name: 'lastName', length: 50)]
    private ?string $lastName = null;

    #[ORM\OneToMany(targetEntity:Book::class, mappedBy:"author", fetch:"LAZY")]
    // La variable de la relation (Foreign Key)
    private $books;

    public function getIdAuthor(): ?int
    {
        return $this->idAuthor;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBooks() : Collection {
        return $this->books;
    }
}
