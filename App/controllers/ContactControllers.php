<?php

namespace Controllers;

use Models\ContactModels;
use Views\ContactViews;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactControllers {
    protected $contactViews;
    protected $contactModels;

    public function __construct() {
        $this->contactViews = new ContactViews();
        $this->contactModels = new ContactModels();
    }

        public function Contact() {
            $this->contactViews->contactViews();
        }

        public function sendMessage() {
            $this->contactModels->sendMessageContact();

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth   = true;
                $mail->Username   = '5c53e815d0a8dd';
                $mail->Password   = 'b1c95af9290d38'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 2525;

                $mail->setFrom('no-reply@yourwebsite.com', 'Votre Site');
                $mail->addAddress($_POST['email'], $_POST['lastname']);

                $mail->isHTML(true);
                $mail->Subject = 'New Contact Message';
                $mail->Body    = $_POST['message'];


                $mail->send();
                echo '<h3>Message envoyer avec succes!</h3>';
            } catch (Exception $e) {
                echo "<h3>Une erreur s'est produite lors de l'envoi du mail : </h3>" . $e->getMessage();
            }
        }
    }
