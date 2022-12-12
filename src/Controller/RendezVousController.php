<?php

namespace App\Controller;

use App\Form\RendezVousType;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class RendezVousController extends AbstractController
{

    #[Route('/rendez-vous', name: 'app_rendez_vous')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousType::class,$rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($rendezVous);
            $entityManager->flush();
            $contactFormData = $form->getData();
            
            $email = (new TemplatedEmail())
                ->from($contactFormData->getEmail())
                ->to('admin@beauty_designer_by_anais.com')
                ->htmlTemplate('email/rendez-vous.html.twig')

            ->context([
            "contact" => $contactFormData
            ]);


            $mailer->send($email);

            $this->addFlash('success', 'Votre demande a été envoyée avec succès !');


            return $this->redirectToRoute('app_rendez_vous');
        }else{
            $this->addFlash('danger', $form->getErrors());
        }
        
        return $this->render('rendez_vous/index.html.twig',[
            'form'=>$form->createView()
        ]);
    
    }
}




