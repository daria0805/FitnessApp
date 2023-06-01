<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $foodTime = null;

    #[ORM\Column(length: 255)]
    private ?string $foodName = null;

    #[ORM\Column]
    private ?int $calories = null;

    #[ORM\Column]
    private ?int $grams = null;

    #[ORM\Column]
    private ?int $carbs = null;

    #[ORM\Column]
    private ?int $fat = null;

    #[ORM\Column]
    private ?int $protein = null;

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
}
