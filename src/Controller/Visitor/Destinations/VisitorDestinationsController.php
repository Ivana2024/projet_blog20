<?php

namespace App\Controller\Visitor\Destinations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VisitorDestinationsController extends AbstractController
{
    #[Route('/visitor/destinations', name: 'app_visitor_destinations',methods:['GET'])]
    public function index(): Response
    {
        return $this->render('pages/visitor/destinations/index.html.twig', );
    }
}
