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
use Faker\Provider\ar_JO\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        Request $request, EntityManagerInterface $manager, PersonneRepository $personneRepository)
    {
        $nom = null;

        if(!$personne)
        {
            $personne = new Personne();
        }else{
            //Ne pas changer le nom_prenom
            $tmpPersonne = new Personne();
            $tmpPersonne = $personneRepository->find($personne->getId());
            $nom = $tmpPersonne->getNomPrenom();
        }

        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            if($nom){
                $personne->setNomPrenom($nom);
            }            
            $manager->persist($personne);
            $manager->flush();
    
            return $this->redirectToRoute('ges_personne');
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
     * @Route("/suprPersonne/{id}", name="supr_personne")
     */
    public function suprPersonne(Personne $personne = null, 
    Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($personne);
        $manager->flush();
        return $this->redirectToRoute('ges_personne');
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

    /**
     * @Route("/suprAdresse/{id}", name="supr_adresse")
     */
    public function suprAdresse(Adresse $adresse = null, 
     EntityManagerInterface $manager)
    {   
        if($adresse->getPersonnes()->count() == 0)
        {
            $manager->remove($adresse);
            $manager->flush();
        }else{
            $this->addFlash(
                'notice',
                'Cette adresse est encore utilisée'
            );
        }
        return $this->redirectToRoute('ges_adresse');
    }
}