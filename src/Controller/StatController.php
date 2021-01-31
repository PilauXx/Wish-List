<?php

namespace App\Controller;

use App\Repository\CadeauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cadeau;
use App\Repository\CategorieRepository;

/**
 * @Route("/stat")
 */
class StatController extends AbstractController
{
    /**
     * @Route("/", name="stat")
     */
    public function index(CadeauRepository $cadeauRepository, Request $request,
        CategorieRepository $categorieRepository): Response
    {
        
        if($request->request->count() > 0)
        {

            //Parité homme femme 
            if($request->request->get('cadeau') != null)
            {
                $cadeau = new Cadeau();
                $cadeau = $cadeauRepository->findOneBy([
                    'id' => $request->request->get('cadeau')
                ]);

                $personnes = $cadeau->getPersonnes();
                $nbHomme = 0;
                $nbFemme = 0;
                $nbAutre = 0;

                //TODO : Remplacer par une requette 
                foreach($personnes as $personne)
                {
                    if($personne->getSexe() == 'homme'){
                        $nbHomme++;
                    }else if($personne->getSexe() == 'femme'){
                        $nbFemme++;
                    }else{
                        $nbAutre++;
                    }
                }

                if($personnes->count() >  0)
                {
                    $homme  = ($nbHomme * 100)/$personnes->count();
                    $femme  = ($nbFemme * 100)/$personnes->count();
                    $autre  = ($nbAutre * 100)/$personnes->count();
                }else {
                    $homme  = 0;
                    $femme  = 0;
                    $autre  = 0;
                }


            }

            return $this->render('stat/stat.html.twig', [
                'cadeaux' => $cadeauRepository->findAll(),
                'categories' => $categorieRepository->findAll(),
                'currentCadeau' => $cadeau,
                'homme' => $homme,
                'femme' => $femme,
                'autre' => $autre
            ]);
        }        

        return $this->render('stat/stat.html.twig', [
            'cadeaux' => $cadeauRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'currentCadeau'=> null,
            'homme' => null,
            'femme' => null,
            'autre' => null
        ]);
    }

    /**
     * @Route("/tranche_age", name="tranche_age")
     */
    public function trancheAge(Request $request)
    {
        if($request->request->count() > 0 )
        {
            //TODO getCategorie en fonction de la tranche d'age
        }

        return $this->render('stat/trancheAge.html.twig',[
            'agePetit' => null,
            'ageGrand' => null,
            'categories' => null
        ]);
    }
}
