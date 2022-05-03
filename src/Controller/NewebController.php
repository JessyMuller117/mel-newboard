<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewebController extends AbstractController
{
    #[Route('/neweb', name: 'app_neweb')]
    public function index(): Response
    {
        return $this->render('neweb/index.html.twig', [
            'controller_name' => 'NewebController',
        ]);
    }
}
