<?php

namespace App\Entity;

use App\Repository\HistoryLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryLogRepository::class)]
class HistoryLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $export_name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $export_date = null;

    #[ORM\Column(length: 255)]
    private ?string $user_name = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExportName(): ?string
    {
        return $this->export_name;
    }

    public function setExportName(string $export_name): self
    {
        $this->export_name = $export_name;

        return $this;
    }

    public function getExportDate(): ?\DateTimeInterface
    {
        return $this->export_date;
    }

    public function setExportDate(\DateTimeInterface $export_date): self
    {
        $this->export_date = $export_date;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
