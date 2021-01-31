<?php

namespace App\Controller;

use App\Entity\Cadeau;
use App\Entity\Personne;
use App\Repository\CadeauRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/souhait")
 */
class SouhaitController extends AbstractController
{
    /**
     * @Route("/", name="souhait")
     */
    public function index(PersonneRepository $personneRepository, Request $request): Response
    {
        if($request->request->count() > 0)
        {
            return $this->render('souhait/souhait.html.twig', [
                'personnes' => $personneRepository->findAll(),
                'listPersonne' => $personneRepository->findOneBy([
                    'id' => $request->request->get('id')
                ])
            ]);
        }

        return $this->render('souhait/souhait.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'listPersonne' => null
        ]);
    }

    /**
     * @Route("/addCadeau/{id}", name="_add_cadeau")
     */
    public function addToList(Personne $personne = null, CadeauRepository $cadeauRepository,
     Request $request, EntityManagerInterface $manager, PersonneRepository $personneRepository)
    {
        if($request->request->count() > 0)
        {
            $cadeau  = new Cadeau();
            $cadeau = $cadeauRepository->findOneBy([
                'id' => $request->request->get('cadeau')
            ]);
            if($cadeau->getAgeMin() < $personne->getAge())
            {
                if($personne->getSouhaits()->contains($cadeau))
                {
                    $this->addFlash(
                        'notice',
                        'Ce cadeau est dèja dans la wishList de cette personne'
                    );
                }else{
                    $personne->addSouhait($cadeau);
            
                    $manager->persist($personne);
                    $manager->flush();
                    
                    return $this->render('souhait/souhait.html.twig', [
                        'personnes' => $personneRepository->findAll(),
                        'listPersonne' => $personne 
                    ]);
                }
            }else
            {
                $this->addFlash(
                    'notice',
                    'Ce cadeau n\'est pas adapté à l\'age de cette personne'
                );
            }
        }
        return $this->render('souhait/addCadeau.html.twig',[
            'cadeaux' => $cadeauRepository->findAll(),
            'personne' => $personne
        ]);
    }

    /**
     * @Route("/suprCadeau/{personne}-{cadeau}", name="_supr_cadeau")
     */
    public function suprToList(Personne $personne = null, Cadeau $cadeau = null, CadeauRepository $cadeauRepository,
        Request $request, EntityManagerInterface $manager, PersonneRepository $personneRepository)
    {

        $personne->removeSouhait($cadeau);
        $manager->persist($personne);
        $manager->flush();
        return $this->render('souhait/souhait.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'listPersonne' => $personne 
        ]);
    }
}
