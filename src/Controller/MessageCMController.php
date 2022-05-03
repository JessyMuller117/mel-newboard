<?php

namespace App\Controller;

use App\Entity\ImageCM;
use App\Entity\MessageCM;
use App\Form\MessageCMType;
use App\Repository\MessageCMRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client/message/cm')]
class MessageCMController extends AbstractController
{
    #[Route('/', name: 'app_message_cm_index', methods: ['GET'])]
    public function index(MessageCMRepository $messageCMRepository): Response
    {
        return $this->render('message_cm/index.html.twig', [
            'message_cms' => $messageCMRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_cm_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageCMRepository $messageCMRepository, ManagerRegistry $doctrine): Response
    {
        $messageCM = new MessageCM();
        $form = $this->createForm(MessageCMType::class, $messageCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Je récupére les images transmises
            $images = $form->get('contenu_image')->getData();

            //On boucle sur les images
            foreach ($images as $image) {
                //Je génére un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //Je copie le fichier dnas le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $entityManager = $doctrine->getManager();

                $img = new ImageCM();
                $img->setName($fichier);
                $messageCM->addContenuImage($img);
            }
            $entityManager->persist($messageCM);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            $messageCM->setClient($this->getUser());
            $messageCMRepository->add($messageCM);
            return $this->redirectToRoute('app_message_cm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_cm/new.html.twig', [
            'message_cm' => $messageCM,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_cm_show', methods: ['GET'])]
    public function show(MessageCM $messageCM): Response
    {
        return $this->render('message_cm/show.html.twig', [
            'message_cm' => $messageCM,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_cm_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessageCM $messageCM, MessageCMRepository $messageCMRepository, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(MessageCMType::class, $messageCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              //Je récupére les images transmises
              $images = $form->get('contenu_image')->getData();

              //On boucle sur les images
              foreach ($images as $image) {
                  //Je génére un nouveau nom de fichier
                  $fichier = md5(uniqid()) . '.' . $image->guessExtension();
  
                  //Je copie le fichier dnas le dossier uploads
                  $image->move(
                      $this->getParameter('images_directory'),
                      $fichier
                  );
  
                  $entityManager = $doctrine->getManager();
  
                  $img = new ImageCM();
                  $img->setName($fichier);
                  $messageCM->addContenuImage($img);
              }
              $entityManager->persist($messageCM);
  
              // actually executes the queries (i.e. the INSERT query)
              $entityManager->flush();
            $messageCMRepository->add($messageCM);
            return $this->redirectToRoute('app_message_cm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_cm/edit.html.twig', [
            'message_cm' => $messageCM,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_cm_delete', methods: ['POST'])]
    public function delete(Request $request, MessageCM $messageCM, MessageCMRepository $messageCMRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageCM->getId(), $request->request->get('_token'))) {
            $messageCMRepository->remove($messageCM);
        }

        return $this->redirectToRoute('app_message_cm_index', [], Response::HTTP_SEE_OTHER);
    }
}
