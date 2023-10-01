<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ORM\Table(name: 'status')]
class Status
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idStatus')]
    private ?int $idStatus = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    #[ORM\OneToMany(targetEntity:Book::class, mappedBy:"status", fetch:"LAZY")]
    // La variable de la relation (Foreign Key)
    private $books;

    public function getIdStatus(): ?int
    {
        return $this->idStatus;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBooks() : Collection {
        return $this->books;
    }
}
