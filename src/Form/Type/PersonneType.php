<?php

namespace App\Form\Type;

use App\Entity\Personne;
use App\Form\Type\AdresseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('sexe', ChoiceType::class, array(
                'choices'   => array('Homme' => 'homme', 'Femme' => 'femme', 'Autre' => 'autre'),
                ), [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('date_nais',BirthdayType::class, [
                'attr' => [
                    'class' => 'form-control'
                    ]
                ])
            ->add('adresse', AdresseType::class)
            ->getForm()
        ;
    }

    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}