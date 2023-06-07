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
}
