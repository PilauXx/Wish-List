<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Adresse;
use App\Form\Type\PersonneForm;
use App\Form\Type\AdresseType;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/secretariat")
*/
class SecretariaController extends AbstractController
{
    /**
     * @Route("/", name="secretariat")
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        return $this->render('views/secretariat.html.twig', [
            'personnes' => $personneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="add_personne")
     * @Route("/edit/{id}", name="edit_personne")
     */
    public function new(Personne $personne = null, 
        Request $request)
    {
        /*
        $personne = new Personne();
        $form = $this->createForm(PersonneForm::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();
            
            return $this->redirectToRoute('secretariat');
        }*/
        
        if(!$personne){
            $personne = new Personne();
        }

        $form = $this->createFormBuilder($personne)
            ->add('nom_prenom', TextType::class)
            ->add('sexe', ChoiceType::class, array(
                'choices'   => array('Homme' => 'homme', 
                'Femme' => 'femme', 'Autre' => 'autre'),
            ))
            ->add('date_nais', BirthdayType::class)
            ->add('adresse', EntityType::class, [
                'class' => Adresse::class,
                'choices' => 'ville'
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();
        ;
        $form->handleRequest($request);

        return $this->render('views/formPersonne.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}