<?php

namespace App\Controller\Visitor\Conseilsauxvoyageurs;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VisitorConseilsauxvoyageursController extends AbstractController
{
    #[Route('/visitor/conseilsauxvoyageurs', name: 'app_visitor_conseilsauxvoyageurs')]
    public function index(): Response
    {
        return $this->render('pages/visitor/conseilsauxvoyageurs/index.html.twig', [
            'controller_name' => 'VisitorConseilsauxvoyageursController',
        ]);
    }
}
