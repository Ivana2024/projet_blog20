<?php
namespace App\Service;


use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class SendEmailService
{

    private MailerInterface $mailer; 

    public function __construct(MailerInterface $mailer)
      {
         $this->mailer = $mailer;
      }

      public function send(array $data = []) : void
      {  

      $senderEmail    =$data['sender_email'];
      $senderName     =$data['sender_name'];
      $recipientEmail =$data['recepient_email'];
      $subject        =$data['subject'];
      // $htmlTemplate    =$data['html_template'];
      $context        =$data['conext'];

      $email =new TemplatedEmail();

      $email->from(new Address($senderEmail,$senderName))
      ->to($recipientEmail)
      ->subject($subject)
      // ->htmlTemplete($htmlTemplate)
      ->context($context)
      ;
      // try
      // {
      //    $this->mailer->send($email);
      // }
      // catch (TransportExceptionInterface $te)
      // {
      //   throw $te;
      // // }
}
}
