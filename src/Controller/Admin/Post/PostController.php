<?php

namespace App\Controller\Admin\Post;

use App\Entity\Post;
use App\Form\PostType;

use DateTimeImmutable;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 
class PostController extends AbstractController
{
    #[Route('/admin/post/list', name: 'admin_post_index', methods:['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('pages/admin/post/index.html.twig', [
            "posts" => $posts
        ]);
    }

    #[Route('/admin/post/create ', name: 'admin_post_create', methods:['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {   
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {   
            $admin = $this->getUser();
            

            $post->setUser($admin);
            $post->setPublished(false);

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', "L'article a été créé et sauvgaré.");

            return $this->redirectToRoute('admin_post_index');
        }
        
        return $this->render('pages/admin/post/create.html.twig', [
            "form" => $form->createView()
        ]);
    } 

    
    #[Route('/admin/post/{id<\d+>}/publish', name: 'admin_post_publish', methods: ['POST'])]
    public function publish(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        //permet de vérifier si le jeton est valide
        if($this->isCsrfTokenValid("publish_post_{$post->getId()}", $request->request->get('_csrf_token') ))
        {
        // Si l'article n'a pas encore été publié
        if ( false === $post->isPublished() ) 
        {
            // Publier l'article
                $post->setPublished(true);
            // Mettre à jour sa date de publication
                $post->setPublichedAt(new DateTimeImmutable());
                          
            // Demander au manager des entités de préparer la requête de modification
                $em->persist($post);
            // Générer le message flash expliquant que l'article a été publié
                $this->addFlash("success", "L'article {$post->getTitle()} a été publié avec succès");

                
        }
        else
        {
            // Retirer l'article de la liste des publications
                $post->setPublished(false);
            // Mettre à nul la date de publication
                $post->setPublichedAt(null);
                            
            // Demander au manager des entités de préparer la requête de modification
                $em->persist($post);
            // Générer le message expliquant de l'article a été retiré de la liste des publications
                $this->addFlash("success", "L'article {$post->getTitle()} a été retiré des publications");
        }
        // Demander au manager des entités d'exécuter la requête préparée
        $em->flush();
        // Effectuer une redirection vers la page listant les articles 
            // Puis, arrêter l'exécution du script
    }       
        return $this->redirectToRoute('admin_post_index');
    }
    #[Route('/admin/post/{id}/show', name: 'admin_post_show', methods:['GET'])]
    public function show(Post $post): Response
    {
        return $this->render("pages/admin/post/show.html.twig",[
            'post' => $post
        ]);
        
    }

    #[Route('/admin/post/{id}/edit', name: 'admin_post_edit', methods:['GET','PUT'])]
    public function edit(Post $post, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(PostType::class, $post, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $admin = $this->getUser();

            $post->setUser($admin);
            $post->setPublished(false);

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', "L'article a été modifié et sauvgaré.");

             return $this->redirectToRoute('admin_post_index');
        }
        
         return $this->render('pages/admin/post/edit.html.twig',[
            'post' => $post,
            'form'=> $form->createView()
         ]);
    }

    #[Route('/admin/post/{id}/delete', name: 'admin_post_delete', methods:['DELETE'])]
    public function delete(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        if ( $this ->isCsrfTokenValid("delete_post_".$post->getId(), $request->request->get('csrf_token'))) 
        {
             $em->remove($post);
             $em->flush();

             $this->addFlash("succes", "L'article a été suprimé.");
        }
        return $this->redirectToRoute("admin_post_index");
    }
} 

 