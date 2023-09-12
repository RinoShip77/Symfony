<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
#[ORM\Table(name: 'evaluations')]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idEvaluation')]
    private ?int $idEvaluation = null;

    #[ORM\Column(name: 'idUser')]
    private ?int $idUser = null;

    #[ORM\Column(name: 'idBook')]
    private ?int $idBook = null;

    #[ORM\Column]
    private ?int $score = null;

    public function getIdEvaluation(): ?int
    {
        return $this->idEvaluation;
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

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }
}
