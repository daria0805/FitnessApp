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
}
