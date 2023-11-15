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

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser', nullable: false)]
    private ?User $user = null;
    
    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(name: 'idBook', referencedColumnName: 'idBook', nullable: false)]
    private ?Book $book = null;
    
    #[ORM\Column]
    private ?int $score = null;
    

    public function getIdEvaluation(): ?int
    {
        return $this->idEvaluation;
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
