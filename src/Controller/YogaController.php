<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Exercise;

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
    /**
     * index
     *
     * @param  mixed $exerciseRepository
     * @return Response
     */
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
     * startWorkout
     *
     * @return Response
     */
    public function startWorkout(): Response
    {
        return $this->render('yoga/start.html.twig');
    }
    public function exitWorkout(): Response
    {
        $exercises = $this->entityManager->getRepository(Exercise::class)->findAll();
        // Perform any necessary cleanup or actions when exiting the workout
        // Get the list of completed exercise IDs (assuming you have a mechanism to track completed exercises)
        $completedExerciseIds = []; // Replace with your logic to retrieve the completed exercise IDs

        // Get the total number of exercises
        $totalExercises = count($exercises); // Replace with your logic to retrieve the total number of exercises
        $currentExercise = count($completedExerciseIds);

        var_dump($exercises);
        // Render the exit workout template with the completed exercise list and well done message
        return $this->render('yoga/exit_workout.html.twig', [
            'completedExerciseIds' => $completedExerciseIds,
            'totalExercises' => $totalExercises,
            'exercises' => $exercises,
            'currentExercise' => $currentExercise,
        ]);
    }
    public function pauseWorkout(Request $request)
    {
        // Redirect back to the workout page
        return $this->redirectToRoute('workout');
    }

    /**
     * @Route("/resume-workout", name="resume_workout", methods={"POST"})
     */
    public function resumeWorkout(Request $request)
    {
        // Perform any necessary logic to resume the workout
        // For example, you can retrieve the paused state of the workout from the session
        // Redirect back to the workout page
        return $this->redirectToRoute('workout');
    }
}
