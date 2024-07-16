<?php

namespace App\Controller\Visitor\Contact;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Service\SendEmailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_visitor_contact_create',methods:['GET','POST'])]
    public function create(Request $request,EntityManagerInterface $em, SendEmailService $sendEmailService): Response
    {   
        $contact = new Contact();

        $form = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
           $em->persist($contact);
           $em->flush();

           $sendEmailService->send([
            'sender_email'=> "monblogdevoyage@gmail.com",
            'sender_name' => "Yann Boulineau",
            'recepient_email'=> "monblogdevoyage@gmail.com",
            'subject'=> "Un message reçu sur votre blog",
            'html_emails'=>"emails/contact.html.twig",
            'conext' => [
                "contact_first_name" => $contact->getFirstName(),
                "contact_last_name" => $contact->getLastName(),
                "contact_email" => $contact->getEmail(),
                "contact_phone" => $contact->getPhone(),
                "contact_message" => $contact->getMessage(),
              ]
            ]);

            $this->addFlash("success", "Votre email a bien été envoyé. Nous vous recontacterons dans le plus bref délais.");
            
            return $this->redirectToRoute('app_visitor_contact_create');
        }
        
        return $this->render('pages/visitor/contact/create.html.twig',[
            "form" =>$form->createView()       
        ]);
    }
}
 
