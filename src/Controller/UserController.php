<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DietPlanDatabase;
use App\Form\WeightFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Meal;

class UserController extends AbstractController
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

    #[Route('/user', name: 'app_user')]
    /**
     * index
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * calculateDietPlan
     *
     * @param  mixed $request
     * @return void
     */
    public function calculateDietPlan(Request $request)
    {
        $form = $this->createForm(WeightFormType::class);
        $form->handleRequest($request);
        $totalCalorieIntake = null;
        $breakfastCalories = 0;
        $lunchCalories = 0;
        $dinnerCalories = 0;
        $isWeightCalculated = false;
        $dietPlanDatabase = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $weight = $form->get('weight')->getData();

            //calculate total calories
            $activityFactor = 1.2;
            $bmr = 370 + (21.6 * ($weight - (0.23 * $weight)));
            $totalCalorieIntake = $bmr * $activityFactor;
            $totalCalorieIntake = round($totalCalorieIntake);

            // Define the percentage distribution for each meal
            $breakfastPercentage = 0.3; // 30%
            $lunchPercentage = 0.4; // 40%
            $dinnerPercentage = 0.3; // 30%

            // Calculate the calories for each meal based on the percentage distribution
            $breakfastCalories = $totalCalorieIntake * $breakfastPercentage;
            $lunchCalories = $totalCalorieIntake * $lunchPercentage;
            $dinnerCalories = $totalCalorieIntake * $dinnerPercentage;

            $user = $this->getUser();
            $dietPlanDatabase = new DietPlanDatabase();
            $dietPlanDatabase->setUser($user);
            $dietPlanDatabase->setWeight($weight);
            $dietPlanDatabase->setTotalCalorieIntake($totalCalorieIntake);
            $dietPlanDatabase->setBreakfastCalories($breakfastCalories);
            $dietPlanDatabase->setLunchCalories($lunchCalories);
            $dietPlanDatabase->setDinnerCalories($dinnerCalories);
            $this->entityManager->persist($dietPlanDatabase);
            $this->entityManager->flush();
            $isWeightCalculated = true;
        }

        return $this->render('user/calculate_diet_plan.html.twig', [
            'form' => $form->createView(),
            'isWeightCalculated' => $isWeightCalculated,
            'totalCalorieIntake' => $totalCalorieIntake,
            'breakfastCalories' => $breakfastCalories,
            'lunchCalories' => $lunchCalories,
            'dinnerCalories' => $dinnerCalories,
            'dietPlanDatabase' => $dietPlanDatabase,
        ]);
    }
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $dietPlanDatabase
     * @return Response
     */
    public function edit(Request $request, DietPlanDatabase $dietPlanDatabase, int $id): Response
    {
        $form = $this->createForm(WeightFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newWeight  = $form->get('weight')->getData();

            //calculate total calories
            $activityFactor = 1.2;
            $bmr = 370 + (21.6 * ($newWeight  - (0.23 * $newWeight )));
            $newtotalCalorieIntake = $bmr * $activityFactor;
            $newtotalCalorieIntake = round($newtotalCalorieIntake);

            // Define the percentage distribution for each meal
            $breakfastPercentage = 0.3; // 30%
            $lunchPercentage = 0.4; // 40%
            $dinnerPercentage = 0.3; // 30%

            // Calculate the calories for each meal based on the percentage distribution
            $newbreakfastCalories = $newtotalCalorieIntake * $breakfastPercentage;
            $newlunchCalories = $newtotalCalorieIntake * $lunchPercentage;
            $newdinnerCalories = $newtotalCalorieIntake * $dinnerPercentage;

            //update the values in the database
            $dietPlanDatabase->setWeight($newWeight);
            $dietPlanDatabase->setTotalCalorieIntake($newtotalCalorieIntake);
            $dietPlanDatabase->setBreakfastCalories($newbreakfastCalories);
            $dietPlanDatabase->setLunchCalories($newlunchCalories);
            $dietPlanDatabase->setDinnerCalories($newdinnerCalories);

            //persist into database
            $this->entityManager->persist($dietPlanDatabase);
            $this->entityManager->flush();
            return $this->redirectToRoute('weight_list', ['id' => $dietPlanDatabase->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'dietPlanDatabase' => $dietPlanDatabase,
        ]);
    }
    /**
     * delete
     *
     * @param  mixed $dietPlanDatabase
     * @param  mixed $id
     * @return Response
     */
    public function delete(DietPlanDatabase $dietPlanDatabase, int $id): Response
    {
        $entityManager = $this->entityManager;
        $dietPlanDatabase = $entityManager->getRepository(DietPlanDatabase::class)->find($id);
        if (!$dietPlanDatabase) {
            throw $this->createNotFoundException('Exercise not found');
        }
        $entityManager->remove($dietPlanDatabase);
        $entityManager->flush();
        return $this->redirectToRoute('weight_list');
        return $this->render('delete.html.twig', [
            'dietPlanDatabase' => $dietPlanDatabase,
        ]);
    }
    /**
     * list
     *
     * @return Response
     */
    public function list(): Response
    {
        $dietPlanDatabases = $this->entityManager->getRepository(DietPlanDatabase::class)->findAll();

        return $this->render('user/list.html.twig', [
            'dietPlanDatabases' => $dietPlanDatabases,
        ]);
    }

    public function adminOnlyPage(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Render the admin-only page template
        return $this->render('admin_only_page.html.twig');
    }
    private function calculateTotalCalories(array $meals): int
    {
        $totalCalories = 0;

        foreach ($meals as $meal) {
            $totalCalories += $meal->getCalories();
        }

        return $totalCalories;
    }
    /**
     * userFoodPage
     *
     * @return Response
     */
    public function userFoodPage(): Response
    {
        $mealRepository = $this->entityManager->getRepository(Meal::class);

        // Filter meals by foodTime
        $breakfastMeals = $mealRepository->findBy(['foodTime' => 'breakfast']);
        $lunchMeals = $mealRepository->findBy(['foodTime' => 'lunch']);
        $dinnerMeals = $mealRepository->findBy(['foodTime' => 'dinner']);

        // Calculate total calories for each meal
        $breakfastCalories = $this->calculateTotalCalories($breakfastMeals);
        $lunchCalories = $this->calculateTotalCalories($lunchMeals);
        $dinnerCalories = $this->calculateTotalCalories($dinnerMeals);

        return $this->render('user/plan.html.twig', [
            'breakfastMeals' => $breakfastMeals,
            'lunchMeals' => $lunchMeals,
            'dinnerMeals' => $dinnerMeals,
            'breakfastCalories' => $breakfastCalories,
            'lunchCalories' => $lunchCalories,
            'dinnerCalories' => $dinnerCalories,
        ]);
    }
}
