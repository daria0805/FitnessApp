<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserFoodController extends AbstractController
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

    #[Route('/user/food', name: 'app_user_food')]
    public function index(): Response
    {
        return $this->render('user_food/index.html.twig', [
            'controller_name' => 'UserFoodController',
        ]);
    }
    // public function searchFood(Request $request, $mealType)
    // {
    //     $searchTerm = $request->query->get('search');

    //     // Retrieve meals matching the search term and meal type from the meal database
    //     $mealRepository = $this->getDoctrine()->getRepository(Meal::class);
    //     $results = $mealRepository->createQueryBuilder('m')
    //         ->where('m.food_name LIKE :searchTerm')
    //         ->andWhere('m.food_time = :mealType')
    //         ->setParameter('searchTerm', '%'.$searchTerm.'%')
    //         ->setParameter('mealType', $mealType)
    //         ->getQuery()
    //         ->getResult();

    //     return $this->render('meal/search.html.twig', [
    //         'searchTerm' => $searchTerm,
    //         'mealType' => $mealType,
    //         'results' => $results,
    //     ]);
    // }
    // public function addFood($mealType, $foodId)
    // {
    //     $user = $this->getUser();
    //     $entityManager = $this->getDoctrine()->getManager();

    //     // Retrieve the selected food from the meal database using $foodId
    //     $mealRepository = $entityManager->getRepository(Meal::class);
    //     $selectedFood = $mealRepository->find($foodId);

    //     // Create a new UserFood entity
    //     $userFood = new UserFood();
    //     $userFood->setFoodName($selectedFood->getFoodName());
    //     $userFood->setCalories($selectedFood->getCalories());
    //     // Set other properties as needed

    //     // Associate the UserFood entity with the current user
    //     $user->addUserFood($userFood);

    //     // Persist the UserFood entity to the user's food database
    //     $entityManager->persist($userFood);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('diet_plan');
    // }
}
