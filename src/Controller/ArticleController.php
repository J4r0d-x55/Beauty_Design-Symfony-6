<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comments;
use App\Form\CommentsType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    private $entityManager;

    public function _construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/article', name: 'app_blog')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();

       
        return $this->render('article/index.html.twig',[
            'articles' => $articles
        ]);
    }

    #[Route('/article/{slug}', name: 'article')]
    public function show(EntityManagerInterface $entityManager, $slug, Request $request): Response
    {
        
        
        $article = $entityManager->getRepository(Article::class)->findOneBySlug($slug);
        
        if(!$article){
            return $this->redirectToRoute('app_blog');
        }
         //Commentaires des articles
        //Créer le commentaire

        $comment = new Comments;

        //Générer le formulaire

        $commentForm = $this->createForm(CommentsType::class, $comment);
        //Récupérer les champs qui sont envoyés

        $commentForm->handleRequest($request);

        //Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setArticles($article);

            //On récupère le contenu du champ parent id
            $parentid = $commentForm->get("parentid")->getData();

            //Récupérer le commentaire correspondant
            if($parentid != null){
                $parent = $entityManager->getRepository(Comments::class)->find($parentid);
            }
           

            //On définit le parent
            $comment->setParent($parent ?? null);

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('message', "Votre commentaire a bien été envoyé");
            return $this->redirectToRoute('article', ['slug' =>
            $article->getSlug()]);
        }

        return $this->render('article/show.html.twig',[
            "article" => $article,
            "commentForm" => $commentForm->createView()
        ]);

       


    }


}
