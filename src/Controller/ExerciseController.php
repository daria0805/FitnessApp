<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Exercise;
use App\Form\ExerciseType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\DeleteFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
        $exercises = $this->entityManager->getRepository(Exercise::class);
        return $this->render('exercise/index.html.twig', [
            'exercises' => $exercises,
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

    #[Route('/exercise/{id}/edit', name: 'exercise_edit')]
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


    #[Route('/exercise/{id}/delete', name: 'exercise_delete')]
    /**
     * delete
     *
     * @param  mixed $request
     * @param  mixed $exercise
     * @param  mixed $entityManager
     * @return Response
     */
    public function delete(Request $request, Exercise $exercise): Response
    {
        // $form = $this->createForm(DeleteFormType::class, null, [
        //     'action' => $this->generateUrl('exercise_delete', ['id' => $exercise->getId()]),
        // ]);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     return $this->redirectToRoute('exercise_list');
        // }
        // return $this->render('exercise/delete.html.twig', [
        //     'form' => $form->createView(),
        //     'exercise' => $exercise,
        // ]);

        $entityManager = $this->entityManager;

        $form = $this->createFormBuilder()
            ->add('confirm', SubmitType::class, ['label' => 'Delete'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($exercise);
            $entityManager->flush();

            $this->addFlash('success', 'Exercise deleted successfully.');

            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/delete.html.twig', [
            'exercise' => $exercise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * list
     *
     * @return Response
     */
    #[Route('/exercise/list', name: 'exercise_list')]
    public function list(): Response
    {
        $exercises = $this->entityManager->getRepository(Exercise::class)->findAll();

        return $this->render('exercise/list.html.twig', [
            'exercises' => $exercises,
        ]);
    }
}
