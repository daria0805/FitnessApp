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
use App\Entity\UserFood;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

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

            $activityFactor = 1.2;
            $bmr = 370 + (21.6 * ($weight - (0.23 * $weight)));
            $totalCalorieIntake = $bmr * $activityFactor;
            $totalCalorieIntake = round($totalCalorieIntake);

            $breakfastPercentage = 0.3; // 30%
            $lunchPercentage = 0.4; // 40%
            $dinnerPercentage = 0.3; // 30%

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

            $activityFactor = 1.2;
            $bmr = 370 + (21.6 * ($newWeight  - (0.23 * $newWeight )));
            $newtotalCalorieIntake = $bmr * $activityFactor;
            $newtotalCalorieIntake = round($newtotalCalorieIntake);

            $breakfastPercentage = 0.3; // 30%
            $lunchPercentage = 0.4; // 40%
            $dinnerPercentage = 0.3; // 30%

            $newbreakfastCalories = $newtotalCalorieIntake * $breakfastPercentage;
            $newlunchCalories = $newtotalCalorieIntake * $lunchPercentage;
            $newdinnerCalories = $newtotalCalorieIntake * $dinnerPercentage;

            $dietPlanDatabase->setWeight($newWeight);
            $dietPlanDatabase->setTotalCalorieIntake($newtotalCalorieIntake);
            $dietPlanDatabase->setBreakfastCalories($newbreakfastCalories);
            $dietPlanDatabase->setLunchCalories($newlunchCalories);
            $dietPlanDatabase->setDinnerCalories($newdinnerCalories);

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

        $breakfastMeals = $mealRepository->findBy(['foodTime' => 'breakfast']);
        $lunchMeals = $mealRepository->findBy(['foodTime' => 'lunch']);
        $dinnerMeals = $mealRepository->findBy(['foodTime' => 'dinner']);

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
    public function addMealToUserFood(Request $request, Security $security): JsonResponse
    {
        $user = $security->getUser();
        $mealId = $request->request->get('mealId');

        $entityManager = $this->entityManager;
        $mealRepository = $entityManager->getRepository(Meal::class);
        $meal = $mealRepository->find($mealId);

        if (!$meal) {
            throw $this->createNotFoundException('Meal not found.');
        }
        $userFood = new UserFood();
        $userFood->setMeal($meal);
        $userFood->setFoodName($meal->getFoodName());
        $userFood->setFoodTime($meal->getFoodTime());
        $userFood->setCalories($meal->getCalories());
        $userFood->setGrams($meal->getGrams());
        $userFood->setCarbs($meal->getCarbs());
        $userFood->setFat($meal->getFat());
        $userFood->setProtein($meal->getProtein());
        $userFood->setUser($user);

        $entityManager->persist($userFood);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
    /**
     * mealChart
     *
     * @return Response
     */
    public function mealChart(): Response
    {
        // Retrieve meal data from the database
        $userFood  = $this->entityManager->getRepository(UserFood::class)->findAll();
        return $this->json($userFood);
        // return $this->render('user/chart.html.twig', [
        //     'userFoodData' => $userFoodData,
        // ]);
    }
    // public function prepareData(): Response
    // {
    //     // Fetch and process data from the database
    //     $userFoodData = $this->entityManager->getRepository(MyEntity::class)->findAll();

    //     // Prepare the data for chart rendering
    //     $chartData = [
    //         'labels' => [],
    //         'data' => [],
    //     ];

    //     foreach ($userFoodData as $item) {
    //         $chartData['labels'][] = $item->getName();
    //         $chartData['data'][] = $item->getValue();
    //     }

    //     // Return a JSON response with the prepared chart data
    //     return new JsonResponse($chartData);
    //     return $this->render('user/chart.html.twig', [
    //         'chartData' => $chartData,
    //     ]);
    // }
    // public function serializeEntity(SerializerInterface $serializer): Response
    // {
    //     // Fetch your entity from the database
    //     $userFoodData = $this->entityManager->getRepository(MyEntity::class)->findAll();

    //     // Serialize the entity while ignoring circular references
    //     $serializedData = $serializer->serialize($userFoodData, 'json', ['circular_reference_handler' => function ($object) {
    //         return $object->getId();
    //     }]);

    //     // Return the serialized data as a response
    //     return new Response($serializedData);
    // }
}
