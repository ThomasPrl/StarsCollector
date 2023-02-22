<?php

namespace App\Controller\Admin;

use App\Entity\Space;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;



class SpaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Space::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),   //L'ID ne peut pas être modifié
            TextField::new('description'),      //Affichage du nom de l'inventaire

            AssociationField::new('stars')     //Affichage du nombre d'étoiles dans l'inventaire
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/space_stars.html.twig'),
                
            AssociationField::new('member')     //Affichage des membres


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
