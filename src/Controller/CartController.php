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
{   #[Route("/cart/commande", name:'app_commande')]
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs, EntityManagerInterface $manager, Request $globals): Response
     {
      $cartWithData=$cs->getCardWithData();
      
      $routeName = $globals->get('_route');
      if($routeName == 'app_commande')
      {
          foreach($cartWithData as $product):
              $commande = new Commande;
              $prix = $product['quantite'] * $product['produit']->getPrix();
              $commande->setDateEnregistrement(new \DateTime);
              $commande->setQuantite($product['quantite']);
              $commande->setMontant($prix);
              $commande->setEtat('en cours de traitement');
              $commande->setIdProduit($product['produit']);
              $commande->setIdMembre($this->getUser());
              $stock= $product['produit']->getStock();
              $stock -= $product['quantite'];
              $product['produit']->setStock($stock);
              $manager->persist($commande);
              $manager->flush();
              

              $cs->remove($product['produit']->getId());
              
          endforeach;
          $this->addFlash('success', "commande a bien été enregistré !");
          //permet de creer un message qui sera affiché une fois a l'utilisateur
          return $this->redirectToRoute('app_app');
      }
      
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

    // #[Route("/cart/adding/{id}", name:"cart_adding")]
    // public function adding($id, CartService $cs) 
    // {
    //     $cs->adding($id);        
    //     return $this->redirectToRoute('app_cart');
    // }
    // #[Route("/cart/decrease/{id}", name:"cart_decrease")]
    // public function decrease($id, CartService $cs) 
    // {
    //     $cs->decrease($id);        
    //     return $this->redirectToRoute('app_cart');
    // }
}