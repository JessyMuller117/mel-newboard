<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Repository\UserRepository;
use App\Repository\MessageCMRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #Permet d'afficher et de traiter le formulaire de modification du profil connecter
    #[Route('/account/profile', name: 'app_account_profile')]
    #[IsGranted('ROLE_USER')]
    public function profile(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont été enregitrée avec succés"
            );
        }
        return $this->render('account/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Permet d'editer un profil !! uniquement visible depuis les admin
    #[Route('/admin/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_account_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account/index.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #Permet d'afficher le profil de l'utilisateur connecter
    #[Route('/account', name: 'app_account_index')]
    #[IsGranted('ROLE_USER')]
    public function myAccount(MessageCMRepository $messageCMRepository){
        return $this->render('account/user.html.twig', [
            'user' => $this->getUser(),
            'message_cms' => $messageCMRepository->findAll(),
        ]);
    }

    #Function qui devrait m'afficher tous les utilisateurs de N3web
    #[Route('/account/n3web', name: 'app_account_n3web')]
    #[IsGranted('ROLE_USER')]
    public function listNeweb(UserRepository $userRepository){
        return $this->render('account/list_neweb.html.twig', [
            'users' => $userRepository->findAll(),
            'user' => $this->getUser()
        ]);
    }


    #Function qui devrait m'afficher tous les clients
    #[Route('/account/client', name: 'app_account_client')]
    #[IsGranted('ROLE_CLIENT')]
    public function listClient(UserRepository $userRepository){
        return $this->render('account/list_client.html.twig', [
            'users' => $userRepository->findAll(),
            'user' => $this->getUser()
        ]);
    }

    #Function qui devrait m'afficher tous les utilisateur
    #[Route('/account/utilisateur', name: 'app_account_user')]
    #[IsGranted('ROLE_USER')]
    public function listUser(UserRepository $userRepository){
        return $this->render('account/list_utilisateur.html.twig', [
            'users' => $userRepository->findAll(),
            'user' => $this->getUser()
        ]);
    }
}

