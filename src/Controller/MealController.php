<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MealRepository;
use App\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;

class MealController extends AbstractController
{
    private $entityManager;

    /**
     * __construct
     *
     * @param  mixed $entityManager
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/meal', name: 'app_meal')]
    public function index(): Response
    {
        return $this->render('meal/index.html.twig', [
            'controller_name' => 'MealController',
        ]);
    }

    public function add(Request $request, MealRepository $mealRepository)
    {
        // Retrieve form data and create a new Meal entity
        $meal = new Meal();
        // Set the properties of the $meal entity based on form data

        // Save the new meal to the database
        $mealRepository->create($meal);

        return $this->redirectToRoute('meal_index');
    }

    public function edit(Request $request, Meal $meal, MealRepository $mealRepository)
    {
        // Update the properties of the $meal entity based on form data

        // Save the updated meal to the database
        $mealRepository->update($meal);

        return $this->redirectToRoute('meal_index');
    }

    public function delete(Request $request, Meal $meal, MealRepository $mealRepository)
    {
        // Delete the meal from the database
        $mealRepository->delete($meal);

        return $this->redirectToRoute('meal_index');
    }
    public function list(): Response
    {
        $meals = $this->entityManager->getRepository(Meal::class)->findAll();

        return $this->render('meal/list.html.twig', [
            'meals' => $meals,
        ]);
    }
}
