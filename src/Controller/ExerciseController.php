<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Exercise;
use App\Form\ExerciseType;
use Doctrine\ORM\EntityManagerInterface;

class ExerciseController extends AbstractController
{
    public EntityManagerInterface $entityManager;
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

    #[Route('/exercise', name: 'app_exercise')]
    /**
     * index
     *
     * @return Response
     */
    public function index(): Response
    {
        $recette = $this->entityManager->getRepository(Exercise::class);
        return $this->render('exercise/index.html.twig', [
            'controller_name' => 'ExerciseController',
        ]);
    }
    /**
     * @Route("/exercise/add", name="exercise_add")
     */
    public function add(Request $request): Response
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // /**
    //  * updateAction
    //  * @param  mixed $request
    //  * @param  mixed $exercise
    //  * @return Response
    //  */
    // #[Route('/exercise/edit', name: 'exercise_edit')]
    // public function update(Request $request, Exercise $exercise): Response
    // {
    //     $form = $this->createForm(ExerciseType::class, $exercise);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->entityManager;
    //          return $this->redirectToRoute('exercise_list', ['id' => $exercise->getId()]);
    //     }
    //     return $this->render('exercise/edit.html.twig', [
    //         'exercise' => $exercise,
    //          'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/exercise/list", name="exercise_list")
     */
    public function list(): Response
    {
        $exercises = $this->entityManager->getRepository(Exercise::class)->findAll();

        return $this->render('exercise/list.html.twig', [
            'exercises' => $exercises,
        ]);
    }
}
