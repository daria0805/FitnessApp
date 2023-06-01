<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DietPlanDatabase;
use App\Form\WeightFormType;
use Doctrine\ORM\EntityManagerInterface;

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
            $dietPlan = new DietPlanDatabase();
            $dietPlan->setUser($user);
            $dietPlan->setWeight($weight);
            $dietPlan->setTotalCalorieIntake($totalCalorieIntake);
            $dietPlan->setBreakfastCalories($breakfastCalories);
            $dietPlan->setLunchCalories($lunchCalories);
            $dietPlan->setDinnerCalories($dinnerCalories);

            $this->entityManager->persist($dietPlan);
            $this->entityManager->flush();
            return new Response('Success');
        }

        return $this->render('user/calculate_diet_plan.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
