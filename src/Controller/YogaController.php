<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class YogaController extends AbstractController
{
    private $exerciseRepository;
    private $entityManager;

    public function __construct(ExerciseRepository $exerciseRepository, EntityManagerInterface $entityManager)
    {
        $this->exerciseRepository = $exerciseRepository;
        $this->entityManager = $entityManager;
    }

    //#[Route('/yoga', name: 'app_yoga')]
    /**
     * index
     *
     * @param  mixed $exerciseRepository
     * @return Response
     */
    public function index(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findBy(['type' => 'yoga']);
        $durations = $this->calculateDurations($exercises);
        $exercisePhotos = [];
        foreach ($exercises as $exercise) {
            $exercisePhotos[] = $exercise->getPhoto();
        }

        if (!$exercises) {
            throw $this->createNotFoundException('Exercises not found');
        }

        return $this->render('yoga/index.html.twig', [
            'exercises' => $exercises,
            'durations' => $durations,
            'exercisePhotos' => $exercisePhotos,
        ]);
    }
    /**
     * calculateDurations
     *
     * @param  mixed $exercises
     * @return array
     */
    private function calculateDurations(array $exercises): array
    {
        $durations = [];
        foreach ($exercises as $exercise) {
            $durations[] = $exercise->getDuration();
        }
        return $durations;
    }
    /**
     * pauseWorkout
     *
     * @param  mixed $request
     * @return void
     */
    public function pauseWorkout(Request $request)
    {
        return $this->redirectToRoute('workout');
    }

    /**
     * @Route("/resume-workout", name="resume_workout", methods={"POST"})
     */
    public function resumeWorkout(Request $request)
    {
        return $this->redirectToRoute('workout');
    }
    public function workoutAction()
    {
        $showExerciseTitle = true;

        return $this->render('yoga/index.html.twig', [
            'showExerciseTitle' => $showExerciseTitle,
        ]);
    }
}
