<?php

namespace App\Form\Type;

use App\Entity\Cadeau;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CadeauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('age_min', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('prix_moyen', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cadeau::class,
        ]);
    }
}
