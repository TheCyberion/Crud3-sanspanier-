<?php

namespace App\Controller;



use App\Entity\Commande;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{   
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs, ): Response
     {
      
      
      $cartWithData = $cs->getCartWithData();
      $total = $cs->getTotal();
      
     return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
             'total' => $total
         ]);
    }

    #[Route('/cart/add/{id}', name:'cart_add')]
    public function add($id, CartService $cs)
    {
        $cs->add($id);
        // $this->addFlash('success', 'Le produit à bien été ajouté !');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove($id, CartService $cs)
    {
        $cs->remove($id);
        // $this->addFlash('warning', 'Le produit à bien été retiré !');
     return $this->redirectToRoute('app_cart');
    }

    #[Route("/cart/commande", name:'app_cart')]
    public function commande(EntityManagerInterface $manager, CartService $cs,): response
    
    { 
        $cartWithData=$cs->getCartWithData();
        foreach($cartWithData as $product){}

            $commande = new Commande;
            $commande->setQuantite($product['quantite']);
            $commande->setEtat('en cours de traitement');
            $commande->setIdMembre($this->getUser());
            $commande->setIdProduit($product['produit']);
            $commande->setDateEnregistrement(new \DateTime);
            $prixProduit= $product['produit']->getPrix();
            $quantite = $product['quantite'];
            $montant=$prixProduit * $quantite;
            $commande->setMontant($montant);
            $manager->persist($commande);
            $manager->flush();

            return $this->redirectToRoute('app_app');
        
    }   
        
       

    //   #[Route("/cart/adding/{id}", name:"cart_adding")]
    //    public function adding($id, CartService $cs) 
    //    {
    //        $cs->adding($id);        
    //       return $this->redirectToRoute('app_cart');
    //    }
    //    #[Route("/cart/decrease/{id}", name:"cart_decrease")]
    //   public function decrease($id, CartService $cs) 
    //   {
    //       $cs->decrease($id);        
    //       return $this->redirectToRoute('app_cart');
    //   }
}