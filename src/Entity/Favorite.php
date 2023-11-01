<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ORM\Table(name: 'favorites')]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idFavorite')]
    private ?int $idFavorite = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser', nullable: false)]
    private ?User $user = null;
    
    #[ORM\ManyToOne(inversedBy: 'book')]
    #[ORM\JoinColumn(name: 'idBook', referencedColumnName: 'idBook', nullable: false)]
    private ?Book $book = null;

    #[ORM\Column(name: 'favoriteDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $favoriteDate = null;

    public function getIdFavorite(): ?int
    {
        return $this->idFavorite;
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

    public function getFavoriteDate(): ?\DateTimeInterface
    {
        return $this->favoriteDate;
    }

    public function setFavoriteDate(\DateTimeInterface $favoriteDate): static
    {
        $this->favoriteDate = $favoriteDate;

        return $this;
    }
}
