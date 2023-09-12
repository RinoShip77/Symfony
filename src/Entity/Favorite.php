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

    #[ORM\Column(name: 'idUser')]
    private ?int $idUser = null;

    #[ORM\Column(name: 'idBook')]
    private ?int $idBook = null;

    #[ORM\Column(name: 'favoriteDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $favoriteDate = null;

    public function getIdFavorite(): ?int
    {
        return $this->idFavorite;
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
