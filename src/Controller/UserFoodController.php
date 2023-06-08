<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserFoodController extends AbstractController
{
    #[Route('/user/food', name: 'app_user_food')]
    public function index(): Response
    {
        return $this->render('user_food/index.html.twig', [
            'controller_name' => 'UserFoodController',
        ]);
    }
}
