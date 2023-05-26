<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Weight;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
    public function addWeight(Request $request, EntityManagerInterface $entityManager)
    {
        // Handle weight input form submission
        // Create and persist Weight entity

        return $this->redirectToRoute('profile');
    }
    // public function calculateCalories()
    // {
    //     // Calculate total calories intake

    //     return $this->redirectToRoute('profile');
    // }
    public function calculateCalories(EntityManagerInterface $entityManager)
    {
        // Calculate total calories intake

        // Calculate breakfast, lunch, and dinner calories

        // Create DailyCalories entity and set the calculated values

        // Save DailyCalories entity to the database

        return $this->redirectToRoute('profile');
    }
}
