<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;
use Intervention\Image\ImageManagerStatic as ImageManager;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $photo;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $photoMimeType;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getPhoto(): ?string
    {
        return $this->photo ? 'images/exercises/' . $this->photo : null;
    }

    public function setPhoto(?string $photo, ?string $photoMimeType): self
    {
        $this->photo = $photo;
        $this->photoMimeType = $photoMimeType;
        if ($photo) {
            $this->resizePhoto();
        }

        return $this;
    }
    public function getPhotoMimeType(): ?string
    {
        return $this->photoMimeType;
    }
    private function resizePhoto(): void
    {
        $photoPath = 'images/exercises/' . $this->photo;
        $resizedPhotoPath = 'images/exercises/' . $this->photo;

        // Define the desired width and height for the resized image
        $desiredWidth = 800;
        $desiredHeight = 600;

        // Resize the image using Intervention Image library
        $resizedImage = ImageManager::make($photoPath)->fit($desiredWidth, $desiredHeight);

        // Save the resized image to the specified path
        $resizedImage->save($resizedPhotoPath);
    }
}
