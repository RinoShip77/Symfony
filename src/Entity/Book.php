<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'books')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idBook')]
    private ?int $idBook = null;
    
    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(name: 'isBorrowed')]
    private ?bool $isBorrowed = null;

    #[ORM\Column(length: 15)]
    private ?string $cover = null;

    #[ORM\Column(name: 'publishedDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publishedDate = null;

    #[ORM\Column(length: 255, name: 'originalLanguage')]
    private ?string $originalLanguage = null;


    #[ORM\ManyToOne(targetEntity: Genre::class, inversedBy:"books", cascade:["persist"])]
    #[ORM\JoinColumn(name:'idGenre', referencedColumnName:'idGenre')]
    // La variable de la relation (Foreign Key)
    private $genre;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy:"books", cascade:["persist"])]
    #[ORM\JoinColumn(name:'idAuthor', referencedColumnName:'idAuthor')]
    // La variable de la relation (Foreign Key)
    private $author;

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): self
    {
        $this->author = $author;

        return $this;
    }


    public function getIdBook(): ?int
    {
        return $this->idBook;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function isIsBorrowed(): ?bool
    {
        return $this->isBorrowed;
    }

    public function setIsBorrowed(bool $isBorrowed): static
    {
        $this->isBorrowed = $isBorrowed;

        return $this;
    }

    public function getCover(): ?int
    {
        return $this->cover;
    }

    public function setCover(int $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(\DateTimeInterface $publishedDate): static
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(string $originalLanguage): static
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }
}