<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Exercise;
use App\Controller\ExerciseController;

class YogaController extends AbstractController
{
    private $exerciseRepository;
    private $entityManager;

    public function __construct(ExerciseRepository $exerciseRepository, EntityManagerInterface $entityManager)
    {
        $this->exerciseRepository = $exerciseRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/yoga', name: 'app_yoga')]
    public function index(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findAll();
        $durations = $this->calculateDurations($exercises);

        $exercisePhotos = [];
        foreach ($exercises as $exercise) {
            $exercisePhotos[] = $exercise->getPhoto();
        }

        if (!$exercises) {
            throw $this->createNotFoundException('Exercises not found');
        }
        return $this->render('yoga/index.html.twig', [
            //'exercise' => $exercise,
            'exercises' => $exercises,
            'durations' => $durations,
            'exercisePhotos' => $exercisePhotos,
        ]);
    }
    private function calculateDurations(array $exercises): array
    {
        $durations = [];
        foreach ($exercises as $exercise) {
            $durations[] = $exercise->getDuration();
        }
        return $durations;
    }
}
