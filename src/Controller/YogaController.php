<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YogaController extends AbstractController
{
    #[Route('/yoga', name: 'app_yoga')]
    public function index(): Response
    {
        return $this->render('yoga/index.html.twig', [
            'controller_name' => 'YogaController',
        ]);
    }
}
