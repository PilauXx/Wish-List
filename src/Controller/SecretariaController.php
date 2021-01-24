<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Adresse;
use App\Form\AdresseType as FormAdresseType;
use App\Form\Type\PersonneType;
use App\Form\Type\AdresseType;
use App\Repository\AdresseRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/newPersonne", name="add_personne")
     * @Route("/editPersonne/{id}", name="edit_personne")
     */
    public function new(Personne $personne = null, 
        Request $request, EntityManagerInterface $manager)
    {
        if(!$personne)
        {
            $personne = new Personne();
        }

        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($personne);
            $manager->flush();
    
            return $this->redirectToRoute('ges_adresse');
        }
        
        

        return $this->render('views/formPersonne.html.twig', [
            'form' => $form->createView(),
            'edit' => $personne->getId() !==null
        ]);
    }

    /**
     * @Route("/gestionPersonne", name="ges_personne")
     */
    public function gesPersonne(PersonneRepository $personneRepository)
    {
        return $this->render('views/secretGesPersonne.html.twig', [
            'personnes' => $personneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/gestionAdresse", name="ges_adresse")
     */
    public function newAdresse(AdresseRepository $adresseRepository)
    {
        return $this->render('views/secretGesAdresse.html.twig', [
            'adresses' => $adresseRepository->findAll(),
        ]);
    }
    /**
     * @Route("/newAdresse", name="new_adresse")
     * @Route("/editAdresse/{id}", name="edit_adresse")
     */
    public function formAdresse(Adresse $adresse = null, 
    Request $request, EntityManagerInterface $manager)
    {
        if(!$adresse)
        {
            $adresse = new Adresse();
        }

        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() )
        {
            $manager->persist($adresse);
            $manager->flush();
    
            return $this->redirectToRoute('ges_adresse');
        }

        return $this->render('views/formAdresse.html.twig', [
            'formAdresse' => $form->createView(),
            'edit' => $adresse->getId() !==null
        ]);
    }
}