<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFinish = null;

    /**
     * @var Collection<int, Employe>
     */
    #[ORM\ManyToMany(targetEntity: Employe::class, inversedBy: 'projects')]
    private Collection $employeAsigned;

    public function __construct()
    {
        $this->employeAsigned = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateFinish(): ?\DateTimeInterface
    {
        return $this->dateFinish;
    }

    public function setDateFinish(\DateTimeInterface $dateFinish): static
    {
        $this->dateFinish = $dateFinish;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmployeAsigned(): Collection
    {
        return $this->employeAsigned;
    }

    public function addEmployeAsigned(Employe $employeAsigned): static
    {
        if (!$this->employeAsigned->contains($employeAsigned)) {
            $this->employeAsigned->add($employeAsigned);
        }

        return $this;
    }

    public function removeEmployeAsigned(Employe $employeAsigned): static
    {
        $this->employeAsigned->removeElement($employeAsigned);

        return $this;
    }
}
