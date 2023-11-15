<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

     #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Book::class)]
     private Collection $books;

    public function __construct()
    {
      //  $this->books = new ArrayCollection();
    }

    //#[ORM\OneToMany(targetEntity:Book::class, mappedBy:"genre", fetch:"LAZY")]
    // La variable de la relation (Foreign Key)
    //private $books;

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

    // /**
    //  * @return Collection<int, Book>
    //  */
    // public function getBooks(): Collection
    // {
    //     return $this->books;
    // }

    // public function addBook(Book $book): static
    // {
    //     if (!$this->books->contains($book)) {
    //         $this->books->add($book);
    //         $book->setGenre($this);
    //     }

    //     return $this;
    // }

    // public function removeBook(Book $book): static
    // {
    //     if ($this->books->removeElement($book)) {
    //         // set the owning side to null (unless already changed)
    //         if ($book->getGenre() === $this) {
    //             $book->setGenre(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getBooks() : Collection {
        return $this->books;
    }
}
