<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idComment')]
    private ?int $idComment = null;

    #[ORM\Column(length: 255)]
    private ?string $reason = null;

    #[ORM\Column(length: 500)]
    private ?string $content = null;

    #[ORM\Column(name: 'isFixed')]
    private ?int $isFixed = 0;

    #[ORM\Column(name: 'createdDate', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(name: 'resolvedDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $resolvedDate = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser', nullable: false)]
    private ?User $user = null;

    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getIsFixed(): ?string
    {
        return $this->isFixed;
    }

    public function setIsFixed(string $isFixed): static
    {
        $this->isFixed = $isFixed;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getResolvedDate(): ?\DateTimeInterface
    {
        return $this->resolvedDate;
    }

    public function setResolvedDate(\DateTimeInterface $resolvedDate): static
    {
        $this->resolvedDate = $resolvedDate;

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
}
