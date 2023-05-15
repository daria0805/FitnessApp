<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Exercise;

class FullWorkoutSetController extends AbstractController
{
    public EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
            $this->entityManager = $entityManager;
    }
    #[Route('/full/workout/set', name: 'app_full_workout_set')]
    public function index(): Response
    {
        $exercises = $this->entityManager->getRepository(Exercise::class)->findAll();

        return $this->render('full_workout_set/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }
}
