<?php

namespace App\Entity;

use App\Repository\BorrowRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BorrowRepository::class)]
#[ORM\Table(name: 'borrows')]
class Borrow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idBorrow')]
    private ?int $idBorrow = null;

    #[ORM\ManyToOne(inversedBy: 'borrows')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser', nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'borrows')]
    #[ORM\JoinColumn(name: 'idBook', referencedColumnName: 'idBook', nullable: false)]
    private ?Book $book = null;

    #[ORM\Column(name: 'borrowedDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $borrowedDate = null;

    #[ORM\Column(name: 'dueDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(name: 'returnedDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $returnedDate = null;

    public function getIdBorrow(): ?int
    {
        return $this->idBorrow;
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

    public function setBook(Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getBorrowedDate(): ?\DateTimeInterface
    {
        return $this->borrowedDate;
    }

    public function setBorrowedDate(\DateTimeInterface $borrowedDate): static
    {
        $this->borrowedDate = $borrowedDate;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getReturnedDate(): ?\DateTimeInterface
    {
        return $this->returnedDate;
    }

    public function setReturnedDate(\DateTimeInterface $returnedDate): static
    {
        $this->returnedDate = $returnedDate;

        return $this;
    }
}
