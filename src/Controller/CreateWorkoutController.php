<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateWorkoutController extends AbstractController
{
    #[Route('/create/workout', name: 'app_create_workout')]
    public function index(): Response
    {
        return $this->render('create_workout/index.html.twig', [
            'controller_name' => 'CreateWorkoutController',
        ]);
    }
}
