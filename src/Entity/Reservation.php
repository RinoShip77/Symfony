<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: 'reservations')]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idReservation')]
    private ?int $idReservation = null;

    #[ORM\Column(name: 'idUser')]
    private ?int $idUser = null;

    #[ORM\Column(name: 'idBook')]
    private ?int $idBook = null;

    #[ORM\Column(name: 'reservationDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $reservationDate = null;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
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

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): static
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }
}
