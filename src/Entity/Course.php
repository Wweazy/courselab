<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $shortDesc = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'course')]
    private Collection $purchases;

    #[ORM\OneToMany(targetEntity: Module::class, mappedBy: 'course', orphanRemoval: true)]
    private Collection $modules;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->modules = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->title;
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getShortDesc(): ?string { return $this->shortDesc; }
    public function setShortDesc(string $shortDesc): static { $this->shortDesc = $shortDesc; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function getPrice(): ?string { return $this->price; }
    public function setPrice(string $price): static { $this->price = $price; return $this; }

    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(string $imageUrl): static { $this->imageUrl = $imageUrl; return $this; }

    public function getCategory(): ?Category { return $this->category; }
    public function setCategory(?Category $category): static { $this->category = $category; return $this; }

    public function getPurchases(): Collection { return $this->purchases; }

    public function getModules(): Collection { return $this->modules; }

    public function addModule(Module $module): static
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setCourse($this);
        }
        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->modules->removeElement($module)) {
            if ($module->getCourse() === $this) {
                $module->setCourse(null);
            }
        }
        return $this;
    }

    public function getContent(): ?string { return $this->content; }
    public function setContent(?string $content): static { $this->content = $content; return $this; }

    public function addPurchase(Purchase $purchase): static { if (!$this->purchases->contains($purchase)) { $this->purchases->add($purchase); $purchase->setCourse($this); } return $this; }
    public function removePurchase(Purchase $purchase): static { if ($this->purchases->removeElement($purchase)) { if ($purchase->getCourse() === $this) { $purchase->setCourse(null); } } return $this; }
}
