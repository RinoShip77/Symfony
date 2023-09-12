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

    #[ORM\Column(name: 'idUser')]
    private ?int $idUser = null;

    #[ORM\Column(name: 'idBook')]
    private ?int $idBook = null;

    #[ORM\Column(name: 'borrowedDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $borrowedDate = null;

    #[ORM\Column(name: 'dueDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(name: 'returnedDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $returnedDate = null;

    public function getIdBorrow(): ?int
    {
        return $this->idBorrow;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdBook(): ?int
    {
        return $this->idBook;
    }

    public function setIdBook(int $idBook): static
    {
        $this->idBook = $idBook;

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
