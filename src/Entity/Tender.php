<?php

namespace App\Entity;

use App\Repository\TenderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TenderRepository::class)]
class Tender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Внешний код не может быть пустым')]
    private ?string $externalCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Номер не может быть пустым')]
    private ?string $number = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Статус обязателен')]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Название не может быть пустым')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Дата обновления обязательна')]
    #[Assert\Type(\DateTimeInterface::class, message: 'Некорректный формат даты')]
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalCode(): ?string
    {
        return $this->externalCode;
    }

    public function setExternalCode(string $externalCode): static
    {
        $this->externalCode = $externalCode;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
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

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(string $string): static
    {
        $this->string = $string;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
