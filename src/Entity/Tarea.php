<?php

namespace App\Entity;

use App\Repository\TareaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TareaRepository::class)]
class Tarea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Descripcion = null;

    #[ORM\Column]
    private ?int $Horas = null;

    #[ORM\Column(length: 20)]
    private ?string $Prioridad = null;

    #[ORM\Column]
    private ?bool $Completado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(string $Descripcion): self
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    public function getHoras(): ?int
    {
        return $this->Horas;
    }

    public function setHoras(int $Horas): self
    {
        $this->Horas = $Horas;

        return $this;
    }

    public function getPrioridad(): ?string
    {
        return $this->Prioridad;
    }

    public function setPrioridad(string $Prioridad): self
    {
        $this->Prioridad = $Prioridad;

        return $this;
    }

    public function isCompletado(): ?bool
    {
        return $this->Completado;
    }

    public function setCompletado(bool $Completado): self
    {
        $this->Completado = $Completado;

        return $this;
    }
}
