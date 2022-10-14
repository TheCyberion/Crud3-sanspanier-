<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use App\Entity\Produit;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAdmin(): Response
    {
         return parent::index();
     }

     public function configureDashboard(): Dashboard
     {
        return Dashboard::new()
             ->setTitle('<b>BACKOFFICE TEA SHIRT</b>');
    }

    public function configureMenuItems(): iterable
    {
         return[
         MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
         MenuItem::section('produit'),
         MenuItem::linkToCrud('Produit', 'fas fa-box',Produit::class),
         MenuItem::section('Membre'),
         MenuItem::linkToCrud('Utilisateurs', 'fas fa-user',Membre::class),
          MenuItem::section("commande"),
          MenuItem::LinkToCrud('commande','fas fa-box', Commande::class),
        MenuItem::section('Home'),
        MenuItem::linkToRoute('Home','fa fa-home','app_app' )
         ];
     }

    
}