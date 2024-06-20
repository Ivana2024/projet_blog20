<?php
namespace App\Controller\Visitor\Quisuisje;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VisitorQuisuisjeController extends AbstractController
{
    #[Route('/quisuisje', name: 'app_visitor_quisuisje',methods:['GET'])]
    public function index(): Response
    {
        return $this->render('pages/visitor/quisuisje/index.html.twig');
    }
}
