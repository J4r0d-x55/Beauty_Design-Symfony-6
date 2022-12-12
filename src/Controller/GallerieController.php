<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GallerieController extends AbstractController
{
    #[Route('/gallerie', name: 'app_gallerie')]
    public function index(): Response
    {
        return $this->render('gallerie/index.html.twig', [
            'controller_name' => 'GallerieController',
        ]);
    }
}
