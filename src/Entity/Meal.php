<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $foodTime = null;

    #[ORM\Column(length: 255)]
    public ?string $foodName = null;

    #[ORM\Column]
    public ?int $calories = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    public ?int $grams = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    public ?int $carbs = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    public ?int $fat = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    public ?int $protein = null;

    #[ORM\OneToMany(mappedBy: 'meal', targetEntity: UserFood::class)]
    private Collection $addUserFood;

    public function __construct()
    {
        $this->addUserFood = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoodTime(): ?string
    {
        return $this->foodTime;
    }

    public function setFoodTime(string $foodTime): self
    {
        $this->foodTime = $foodTime;

        return $this;
    }

    public function getFoodName(): ?string
    {
        return $this->foodName;
    }

    public function setFoodName(string $foodName): self
    {
        $this->foodName = $foodName;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getGrams(): ?int
    {
        return $this->grams;
    }

    public function setGrams(int $grams): self
    {
        $this->grams = $grams;

        return $this;
    }

    public function getCarbs(): ?int
    {
        return $this->carbs;
    }

    public function setCarbs(int $carbs): self
    {
        $this->carbs = $carbs;

        return $this;
    }

    public function getFat(): ?int
    {
        return $this->fat;
    }

    public function setFat(int $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getProtein(): ?int
    {
        return $this->protein;
    }

    public function setProtein(int $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    /**
     * @return Collection<int, UserFood>
     */
    public function getAddUserFood(): Collection
    {
        return $this->addUserFood;
    }

    public function addAddUserFood(UserFood $addUserFood): self
    {
        if (!$this->addUserFood->contains($addUserFood)) {
            $this->addUserFood->add($addUserFood);
            $addUserFood->setMeal($this);
        }

        return $this;
    }

    public function removeAddUserFood(UserFood $addUserFood): self
    {
        if ($this->addUserFood->removeElement($addUserFood)) {
            // set the owning side to null (unless already changed)
            if ($addUserFood->getMeal() === $this) {
                $addUserFood->setMeal(null);
            }
        }

        return $this;
    }
}
