<?php 

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;

class ServiceMail
{

    public function send(string $form, string $to, string $subject,$template,array $context):void
    {
        /*private $mailer ;

        public function __construct(MailerInterface $mailer)
        {
            $this-> mailer = $mailer ;
        }
        
        
        //On crée le mail*/
    }
}