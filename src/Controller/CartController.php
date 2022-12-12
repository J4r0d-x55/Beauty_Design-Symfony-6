<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'cart')]

    public function getFull(SessionInterface $session, ProductRepository $productsRepository)
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $product = $productsRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
            
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }
    
    #[Route('/add/{id}', name: 'cart_add')]

    public function add(Product $product, SessionInterface $session)
    {
        
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart");
    }

    
    #[Route("/remove/{id}", name:"cart_remove")]
    
    public function remove(Product $product, SessionInterface $session)
    {
        
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart");
    }

    
    #[Route("/delete/{id}", name:"cart_delete")]
    
    public function delete(Product $product, SessionInterface $session)
    {
        
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart");
    }

    
    #[Route("/delete", name:"cart_delete_all")]
    
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart");
    }

}
