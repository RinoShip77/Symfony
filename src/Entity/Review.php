<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: 'reviews')]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idReview')]
    private ?int $idReview = null;

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\Column()]
    private ?int $rating = null;

    #[ORM\Column(name: 'reviewDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $reviewDate = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser', nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: 'idBook', referencedColumnName: 'idBook', nullable: false)]
    private ?Book $book = null;

    public function getIdReview(): ?int
    {
        return $this->idReview;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReviewDate(): ?\DateTimeInterface
    {
        return $this->reviewDate;
    }

    public function setReviewDate(\DateTimeInterface $reviewDate): static
    {
        $this->reviewDate = $reviewDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
