<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Service\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/app', name: 'app_app')]
    public function index(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll();
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'produit'=>$produits,
        ]);
    }

    #[Route('/app/register', name:'app_register')]
    public function add()
    {
        return $this->render('app/register.html.twig'[
            
        ]);
    }

    #[Route('profil' , name:"app_profil")]
    public function profil(CommandeRepository $repo)
    {
        $commandes = $repo->findAll();

        return $this->render('app/profil.html.twig',[
            'commandes'=> $commandes
        ]);
    }

    #[Route('/show/{id}', name: 'app_show')]
    public function show(ProduitRepository $repo, $id, RequestStack $rs)
    {
        $produit = $repo->find($id);
        $session = $rs->getSession();
        $cart = $session->get('cart', []);
        if(!empty($cart[$id]))
        {
            $cartQuantite = $cart[$id];
            $stock = $produit->getStock();
            $encore= $stock - $cartQuantite;
        }
        else{
            $encore = $produit->getStock();
        }
        return $this->render('app/show.html.twig',[
            'produit' => $produit,
            "maxQuantite" => $encore,
        ]);
    } 

    #[Route ("/commande/{id}", name:"app_commande")]
    public function showCommande($id, CommandeRepository $repo)
    {
        $commande = $repo->find($id);
    
        return $this->render("app/cart.html.twig", [
            'commande' => $commande
        ]);
    }
    
}
