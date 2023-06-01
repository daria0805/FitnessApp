<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ExerciseType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Exercise;

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

    /**
     * index
     *
     * @return Response
     */
    public function index(): Response
    {
        $exercises = $this->entityManager->getRepository(Exercise::class);
        return $this->render('exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }
    /**
     * add
     *
     * @param  mixed $request
     * @return Response
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

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $exercise
     * @return Response
     */
    public function edit(Request $request, Exercise $exercise): Response
    {
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->flush();

            return $this->redirectToRoute('exercise_list', ['id' => $exercise->getId()]);
        }

        return $this->render('exercise/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * delete
     *
     * @param  mixed $exercise
     * @param  mixed $id
     * @ParamConverter("exercise", class="App\Entity\Exercise")
     * @return Response
     */
    public function delete(Exercise $exercise, int $id): Response
    {
        $entityManager = $this->entityManager;
        $exercise = $entityManager->getRepository(Exercise::class)->find($id);
        if (!$exercise) {
            throw $this->createNotFoundException('Exercise not found');
        }
        $entityManager->remove($exercise);
        $entityManager->flush();
        return $this->redirectToRoute('exercise_list');
        return $this->render('delete.html.twig', [
            'exercise' => $exercise,
        ]);
    }
    /**
     * list
     *
     * @return Response
     */
    public function list(): Response
    {
        $exercises = $this->entityManager->getRepository(Exercise::class)->findAll();

        return $this->render('exercise/list.html.twig', [
            'exercises' => $exercises,
        ]);
    }
}
