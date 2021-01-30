<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdresseRepository;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(AdresseRepository $adresseRepository, Request $request): Response
    {
        if($request->request->count() > 0)
        {
            return $this->render('views/home.html.twig', [
                'allAdresses' => $adresseRepository->findAll(),
                'adresses' => $adresseRepository->findBy([
                    'ville' => $request->request->get('ville')
                ])
            ]);
        }

        return $this->render('views/home.html.twig', [
            'allAdresses' => $adresseRepository->findAll(),
            'adresses' => null
        ]);
    }
}