<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MessagesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        
    }
    #[Route('/messages', name: 'app_messages')]
    public function index(): Response
    {
        return $this->render('messages/index.html.twig');
    }

    // Fonction pour envoyer un message
    #[Route('/envoi', name: 'app_send')]
    public function send(Request $request): Response
    {
        // Créer la vue du formulaire de message
        $message = new Messages;
        $form = $this->createForm(MessagesType::class, $message);

        // Récupérer le formulaire dans la requete et le traiter
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());

            $this->entityManager->persist($message);
            $this->entityManager->flush(); 

            $this->addFlash("message", "Votre message a bien été envoyé");
            return $this->redirectToRoute("app_messages");
        }

        return $this->render("messages/send.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route('/reçu', name: 'app_received')]
    public function received(): Response
    {
        return $this->render('messages/received.html.twig');
    }

    #[Route('/lire/{id}', name: 'app_read')]
    public function read(Messages $message): Response
    {
        $message->setIsRead(true);

        $this->entityManager->persist($message);
        $this->entityManager->flush(); 

        return $this->render('messages/read.html.twig', compact("message"));
    }

    #[Route('/supprimer/{id}', name: 'app_delete')]
    public function delete(Messages $message): Response
    {

        $this->entityManager->remove($message);
        $this->entityManager->flush(); 

        return $this->redirectToRoute("app_recu");
    }

    #[Route('/envoyé', name: 'app_sent')]
    public function sent(): Response
    {
        return $this->render('messages/sent.html.twig');
    }
}
