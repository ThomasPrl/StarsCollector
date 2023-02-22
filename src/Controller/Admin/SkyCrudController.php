<?php

namespace App\Controller\Admin;

use App\Entity\Sky;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Doctrine\ORM\QueryBuilder;


class SkyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
    return Sky::class;
    }

    public function configureFields(string $pageName): iterable
    {

    return [
        IdField::new('id')->hideOnForm(),
        AssociationField::new('createur'),
        BooleanField::new('publish')
        ->onlyOnForms()
        ->hideWhenCreating(),
        TextField::new('description'),

        AssociationField::new('stars')
        ->onlyOnForms()
        // on ne souhaite pas gérer l'association entre les
        // stars et la sky dès la crétion de la
        // Sky
        ->hideWhenCreating()
        ->setTemplatePath('admin/fields/space_stars.html.twig')
        // Ajout possible seulement pour des stars qui
        // appartiennent même propriétaire du space
        // que le member de la Sky
        ->setQueryBuilder(
            function (QueryBuilder $queryBuilder) {
            // récupération de l'instance courante de sky
            $currentSky = $this->getContext()->getEntity()->getInstance();
            $member = $currentSky->getCreateur();
            $memberId = $member->getId();
            // charge les seuls stars dont le 'owner' du space est le member de la galerie
            $queryBuilder->leftJoin('entity.space', 'i')
                ->leftJoin('i.member', 'm')
                ->andWhere('m.id = :member_id')
                ->setParameter('member_id', $memberId);    
            return $queryBuilder;
            }
           ),
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