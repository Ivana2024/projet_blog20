<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{


    public function __construct( private EntityManagerInterface $em)
    {
        
    }
    #[Route('/admin/category/list', name: 'admin_category_index', methods:['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        
        return $this->render('pages/admin/category/index.html.twig', [
            "categories" => $categories
        ]);
    }

    #[Route('/admin/category', name: 'admin_category_create', methods:['GET','POST'])]
    public function create(Request $request,EntityManagerInterface $em):Response
    { 
        $category = new Category();
 
       $form = $this->createForm(CategoryFormType::class,$category);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
            $em->persist($category);
            $em->flush() ;

            $this->addFlash("success","La catégorie a été ajoutée.");

            return $this->redirectToRoute('admin_category_index');
       }
    
        return $this->render('pages/admin/category/create.html.twig',[
            "form" =>$form->createView()
        ]);
    }

    #[Route('/admin/category/{id}/edit', name: 'admin_category_edit', methods:['GET','POST'])]
    public function edit(Category $category, Request $request): Response
    {  
         $form = $this->createForm(CategoryFormType::class,$category,[
            "method" => "POST"
         ]);
          
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($category);
            $this->em->flush();

            $this->addFlash('success',"La catégorie a été modifiée");

            return $this->redirectToRoute("admin_category_index");
        }

        return $this->render("pages/admin/category/edit.html.twig",[
            "form" => $form->createView()
            
        ]);
    }
    #[Route('/admin/category/{id}/delete', name: 'admin_category_delete', methods:['GET','POST'])]
    public function delete(Category $category, Request $request,EntityManagerInterface $em): Response
    { 
     if( $this->isCsrfTokenValid('delete_category_'.$category->getId(), $request->request->get('csrf_token')))
    {
        $em->remove($category);
        $em->flush();
   
        $this->addFlash('success', "La catégorie a été suprimée.");
    }
        return $this->redirectToRoute('admin_category_index');
    }
}
