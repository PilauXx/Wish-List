<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CadeauRepository;
use App\Repository\CategorieRepository;
use App\Entity\Cadeau;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Form\Type\CadeauType;
use App\Form\Type\CategorieType;

/**
 * @Route("/stock")
 */
class StockController extends AbstractController
{
    /**
     * @Route("/", name="stock")
     */
    public function index(CadeauRepository $cadeauRepositiry): Response
    {
        return $this->render('views/stock.html.twig', [
            'cadeaux' => $cadeauRepositiry->findAll(),
        ]);
    }

    /**
     * @Route("/newCadeau", name="add_cadeau")
     * @Route("/editCadeau/{id}", name="edit_cadeau")
     */
    public function new(Cadeau $cadeau = null, Request $request, 
        EntityManagerInterface $manager, CadeauRepository $cadeauRepositiry)
    {
        $designation = null;

        if(!$cadeau){
            $cadeau = new Cadeau();
        }else{
            $tmpCadeau = new Cadeau();
            $tmpCadeau = $cadeauRepositiry->find($cadeau->getId());
            $designation = $tmpCadeau->getDesignation();
        }

        $form = $this->createForm(CadeauType::class, $cadeau);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($designation){
                $cadeau->setDesignation($designation);
            }
            $manager->persist($cadeau);
            $manager->flush();
    
            return $this->redirectToRoute('ges_stock');
        }

        return $this->render('views/formCadeau.html.twig', [
            'form' => $form->createView(),
            'edit' => $cadeau->getId() !== null
        ]);
    }

    /**
     * @Route("/gestionCadeau", name="ges_stock")
     */
    public function gestCadeau(CadeauRepository $cadeauRepositiry)
    {
        return $this->render('views/stockGesCadeau.html.twig', [
            'cadeaux' => $cadeauRepositiry->findAll()
        ]);
    } 

    /**
     * @Route("/suprCadeau/{id}", name="supr_cadeau")
     */
    public function suprCadeau(Cadeau $cadeau = null, CadeauRepository $cadeauRepositiry,
    EntityManagerInterface $manager)
    {
        if($cadeau->getPersonnes()->count() == 0){
            $manager->remove($cadeau);
            $manager->flush();
        }else{
            $this->addFlash(
                'notice',
                'Cette cadeau est désiré par quelqu\'un ! Vous ne pouvez pas le suprimer.'
            );
        }
        return $this->redirectToRoute('ges_stock');
    }

    /**
     * @Route("/gestionCategorie", name="ges_categorie")
     */
    public function newCategorie(CategorieRepository $categorieRepository)
    {
        return $this->render('views/stockGesCategorie.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newCategorie", name="new_categorie")
     * @Route("/editCategorie/{id}", name="edit_categorie")
     */
    public function formCategorie(categorie $categorie = null, 
    Request $request, EntityManagerInterface $manager)
    {
        if(!$categorie)
        {
            $categorie = new Categorie();
        }

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() )
        {
            if($request->request->get('modifPrix')!=null)
            {
                $cadeaux = $categorie->getCadeaux();
                foreach($cadeaux as $cadeau){
                    $prix = $cadeau->getPrixMoyen();
                    $diviser = $request->request->get('modifPrix')/100;
                    $prix = $prix + ($prix*$diviser);
                    $cadeau->setPrixMoyen($prix);
                    $manager->persist($cadeau);
                }
            }
            $manager->persist($categorie);
            $manager->flush();
    
            return $this->redirectToRoute('ges_categorie');
        }

        return $this->render('views/formCategorie.html.twig', [
            'form' => $form->createView(),
            'edit' => $categorie->getId() !==null
        ]);
    }
}