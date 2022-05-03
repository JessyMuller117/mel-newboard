<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use App\Repository\EvenementRepository;
use App\Repository\MessageCMRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntrepriseRepository $entrepriseRepository, UserRepository $userRepository, EvenementRepository $evenementRepository, MessageCMRepository $messageCMRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
            'last_entreprise' => $entrepriseRepository->findOneBy([], ['createAt' => 'desc'],1,0),
            'users' => $userRepository->findAll(),
            'clients' => $userRepository->findByRole('ROLE_CLIENT'),
            'evenements' => $evenementRepository->findAll(),
            'last_evenement' => $evenementRepository->findOneBy([], ['date' => 'asc'], 1,0),
            'message_cm' => $messageCMRepository-> findAll()
        ]);
    }
}