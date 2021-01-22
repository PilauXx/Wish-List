<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StocksController extends AbstractController
{
    /**
     * @Route("/stocks", name="gestion_stocks")
     */
    public function index(): Response
    {
        return $this->render('views/stocks.html.twig', [
            'controller_name' => 'StocksController',
        ]);
    }
}