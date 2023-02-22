<?php

namespace App\Controller\Admin;

use App\Entity\Star;
use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;



class StarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        
        return Star::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

        IdField::new('id')->hideOnForm(),
        TextField::new('description'),
        IntegerField::new('mass'),
        IntegerField::new('temperature'),
        IntegerField::new('diameter'),
        
        AssociationField::new('types')
        ->onlyOnDetail()
        ->formatValue(function ($value, $entity) {
            return implode(', ', $entity->getTypes()->toArray()); // ici getBodyShapes()
        }) 
     ];

    }
   //Affichage du menu "Show" dans les options d'inventaire
   public function configureActions (Actions $actions) : Actions
   {
   return $actions
   ->add (Crud::PAGE_INDEX, Action::DETAIL)
   ;
   }
}   
