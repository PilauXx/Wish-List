<?php

namespace App\Form\Type;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rue', TextType::class, [
            'attr' => [
                'class' => 'form-control'
                ]
            ])
            ->add('num_rue', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('code_post', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
