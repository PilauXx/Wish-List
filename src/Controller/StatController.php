<?php

namespace App\Controller;

use App\Entity\Cadeau;
use App\Repository\CadeauRepository;
use App\Repository\PersonneRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function trancheAge(Request $request, PersonneRepository $personneRepositoriy)
    {
        if($request->request->count() > 0 )
        {
            //TODO utiliser un queryBuilder

            $min = $request->request->get('min');
            $max = $request->request->get('max');

            $categorie = new ArrayCollection();
            
            $personnes = $personneRepositoriy->findAll();

            // C'est lourd de ouf :/ 
            foreach($personnes as $personne)
            {
                if($personne->getAge() > $min && $personne->getAge() < $max)
                {
                    foreach($personne->getSouhaits() as $cadeau)
                    {
                        if(!$categorie->contains($cadeau->getCategorie()))
                        {
                            $categorie->add($cadeau->getCategorie());
                        }
                    }         
                }
            }

            return $this->render('stat/trancheAge.html.twig',[
                'agePetit' => $min,
                'ageGrand' => $max,
                'categories' => $categorie
            ]);
        }

        return $this->render('stat/trancheAge.html.twig',[
            'agePetit' => null,
            'ageGrand' => null,
            'categories' => null
        ]);
    }
}
