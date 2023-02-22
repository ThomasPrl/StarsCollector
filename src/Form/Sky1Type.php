<?php

namespace App\Form;

use App\Entity\Sky;
use App\Repository\StarRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Sky1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump ($options);
        $sky = $options['data'] ??  null;
        $member = $sky->getCreateur();

        $builder
            ->add('description')
            ->add('publish')
            ->add('createur', null, [
                'disabled' => true,
            ])
            ->add('stars', null, [
                'query_builder' => function (StarRepository $er) use ($member) {
                        return $er->createQueryBuilder('g')
                        ->leftJoin('g.space', 'i')
                        ->andWhere('i.member = :member')
                        ->setParameter('member', $member)
                        ;
                    }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sky::class,
        ]);
    }
}
