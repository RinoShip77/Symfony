<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    #[ORM\OneToMany(mappedBy: 'author', targetEntity:Book::class, orphanRemoval: true, cascade:['persist'])]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class)]
     private Collection $books;

    public function __construct()
    {
      //  $this->books = new ArrayCollection();
    }

    //#[ORM\OneToMany(targetEntity:Book::class, mappedBy:"author", fetch:"LAZY")]
    // La variable de la relation (Foreign Key)
    //private $books; 

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

 /*    public function getBooks() : Collection {
        return $this->books;
    } */

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
    //         $book->setAuthor($this);
    //     }

    //     return $this;
    // }

    // public function removeBook(Book $book): static
    // {
    //     if ($this->books->removeElement($book)) {
    //         // set the owning side to null (unless already changed)
    //         if ($book->getAuthor() === $this) {
    //             $book->setAuthor(null);
    //         }
    //     }

    //     return $this;
    // }
}
