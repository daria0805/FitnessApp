<?php

namespace App\Entity;

use App\Repository\DietPlanDatabaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DietPlanDatabaseRepository::class)]
class DietPlanDatabase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy : "dietPlanDatabase")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false)]
    private $user;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?int $totalCalorieIntake = null;

    #[ORM\Column]
    private ?int $breakfastCalories = null;

    #[ORM\Column]
    private ?int $lunchCalories = null;

    #[ORM\Column]
    private ?int $dinnerCalories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getTotalCalorieIntake(): ?int
    {
        return $this->totalCalorieIntake;
    }

    public function setTotalCalorieIntake(int $totalCalorieIntake): self
    {
        $this->totalCalorieIntake = $totalCalorieIntake;

        return $this;
    }

    public function getBreakfastCalories(): ?int
    {
        return $this->breakfastCalories;
    }

    public function setBreakfastCalories(int $breakfastCalories): self
    {
        $this->breakfastCalories = $breakfastCalories;

        return $this;
    }

    public function getLunchCalories(): ?int
    {
        return $this->lunchCalories;
    }

    public function setLunchCalories(int $lunchCalories): self
    {
        $this->lunchCalories = $lunchCalories;

        return $this;
    }

    public function getDinnerCalories(): ?int
    {
        return $this->dinnerCalories;
    }

    public function setDinnerCalories(int $dinnerCalories): self
    {
        $this->dinnerCalories = $dinnerCalories;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
