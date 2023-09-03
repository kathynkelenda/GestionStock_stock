<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

    require_once "Exception.php";
    require_once "PHPMailer.php";
    require_once "SMTP.php";

    $mail= new PHPMailer(true);

    try {
        
        //Configuration
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        //On configure le SMTP
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'ee19f6bd696bb0';
        $phpmailer->Password = '********f084';

        //charset
        $mail->charset ="utf_8";

        //Sestinataire
    } catch (Exception $e) {
        echo "Message non envoyé. Erreur:{$mail->ErrorInfo}";
        
    }
    


?>