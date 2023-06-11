<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MealRepository;
use App\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\MealFormType;
use App\Entity\UserFood;

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
            'controller_name' => 'MealController'
        ]);
    }

    /**
     * add
     *
     * @param  mixed $request
     * @return void
     */
    public function add(Request $request)
    {
        $meal = new Meal();
        $form = $this->createForm(MealFormType::class, $meal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->persist($meal);
            $entityManager->flush();

            return $this->redirectToRoute('meal_list');
        }

        return $this->render('meal/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $meal
     * @return void
     */
    public function edit(Request $request, Meal $meal)
    {
        $form = $this->createForm(MealFormType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->flush();

            return $this->redirectToRoute('meal_list', ['id' => $meal->getId()]);
        }

        return $this->render('meal/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * delete
     *
     * @param  mixed $meal
     * @param  mixed $id
     * @return void
     */
    public function delete(Meal $meal, int $id)
    {
        $entityManager = $this->entityManager;
        $meal = $entityManager->getRepository(Meal::class)->find($id);
        if (!$meal) {
            throw $this->createNotFoundException('Meal not found');
        }
        $entityManager->remove($meal);
        $entityManager->flush();
        return $this->redirectToRoute('meal_list');
        return $this->render('delete.html.twig', [
            'meal' => $meal,
        ]);
    }

    /**
     * list
     *
     * @return Response
     */
    public function list(): Response
    {
        $meals = $this->entityManager->getRepository(Meal::class)->findAll();

        return $this->render('meal/list.html.twig', [
            'meals' => $meals,
        ]);
    }

    // public function searchUserFood(Request $request, $mealType)
    // {
    //     $results = $this->entityManager;
    //     $searchTerm = $request->query->get('search');

    //     // Retrieve meals matching the search term and meal type from the meal database
    //     $mealRepository = $this->entityManager->getRepository(Meal::class);
    //     $results = $mealRepository->createQueryBuilder('m')
    //         ->where('m.food_name LIKE :searchTerm')
    //         ->andWhere('m.food_time = :mealType')
    //         ->setParameter('searchTerm', '%' . $searchTerm . '%')
    //         ->setParameter('mealType', $mealType)
    //         ->getQuery()
    //         ->getResult();

    //     return $this->render('meal/search.html.twig', [
    //         'searchTerm' => $searchTerm,
    //         'mealType' => $mealType,
    //         'results' => $results,
    //     ]);
    // }

    // public function addUserFood(int $mealType, int $foodId)
    // {
    //     $entityManager = $this->entityManager;
    //     $mealRepository = $this->entityManager->getRepository(Meal::class);
    //     $selectedFood = $mealRepository->find($foodId);

    //     // Retrieve the selected food from the meal database using $foodId
    //     $mealRepository = $entityManager->getRepository(Meal::class);
    //     $selectedFood = $mealRepository->find($foodId);

    //     // Create a new UserFood entity
    //     $userFood = new UserFood();
    //     $userFood->setFoodName($selectedFood->getFoodName());
    //     $userFood->setGrams($selectedFood->getGrams());
    //     $userFood->setCalories($selectedFood->getCalories());
    //     $userFood->setCarbs($selectedFood->getCarbs());
    //     $userFood->setProtein($selectedFood->getProtein());
    //     $userFood->setFat($selectedFood->getFat());

    //     $user = $this->getUser();
    //     $user->addAddUserFood($userFood);

    //     // Persist the UserFood entity to the user's food database
    //     $entityManager->persist($userFood);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('diet_plan');
    // }
}
