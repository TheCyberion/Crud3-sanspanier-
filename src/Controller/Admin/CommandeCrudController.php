<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
     {
         return Commande::class;
    }

    
     public function configureFields(string $pageName):iterable
    {
        return [
             IdField::new('id')->hideOnForm(),
            //  TextField::new('membre'),
            //  TextField::new('produit'),
             AssociationField::new('id_membre')->renderAsNativeWidget(),
             AssociationField::new('id_produit')->renderAsNativeWidget(),
             IntegerField::new('quantite'),
             MoneyField::new('montant')->setCurrency('EUR'),
             ChoiceField::new('etat')->setChoices(['en cours de traitement'=>'en cours de traitement', 'envoyée'=>'envoyée','livrée'=>'livrée']),
             DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm(),
         ];
    }
   
}
