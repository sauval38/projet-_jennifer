<?php

namespace Controllers;

use Models\FormForgotPasswordModels;
use Views\FormForgotPasswordViews;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class FormForgotPasswordControllers {
    protected $formForgotPasswordModels;
    protected $formForgotPasswordViews;
   
    public function __construct() {
        $this->formForgotPasswordModels = new FormForgotPasswordModels ();
        $this->formForgotPasswordViews = new FormForgotPasswordViews ();
    }    

    public function FormForgotPassword() {
        $this->formForgotPasswordViews->formForgotPasswordViews();
    }

    public function getEmailByUser() {
        // Récupération de l'email et du token
        $data = $this->formForgotPasswordModels->emailByUser();
    
        if ($data) {
            // Envoi de l'email avec l'adresse et le token récupérés
            $email = $data['email'];
            $token = $data['token'];
            $this->sendPasswordEmail($email, $token);
        } else {
            // Gestion du cas où l'utilisateur n'est pas trouvé
            echo "<h3>Aucun utilisateur trouvé avec cet identifiant ou email.</h3>";
        }
    }
    
    private function sendPasswordEmail($email, $token) {
        // Créer une instance de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP pour Mailtrap
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';  // Le serveur SMTP de Mailtrap
            $mail->SMTPAuth   = true;                // Activer l'authentification SMTP
            $mail->Username   = 'dffb3dbaf6ac0c';    // Nom d'utilisateur Mailtrap
            $mail->Password   = 'bf1735b7df1071';      // Mot de passe Mailtrap
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Activer le chiffrement TLS
            $mail->Port       = 2525;                // Port utilisé par Mailtrap

            // Définir l'expéditeur et le destinataire
            $mail->setFrom('no-reply@yourwebsite.com', 'Votre Site');
            $mail->addAddress($email);  // Le destinataire (l'utilisateur qui s'inscrit)

            // Contenu de l'email
            $mail->isHTML(true);                                  // Activer le format HTML
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $mail->Body    = "Cliquez sur ce lien pour modifier votre mot de passe : <a href='http://localhost/projet-_jennifer/?action=password&token=$token'>Réinitialiser de votre mot de passe</a>";
            $mail->AltBody = "Cliquez sur ce lien pour Réinitialiser de votre mot de passe : http://localhost/projet-_jennifer/?action=password&token=$token"; // Version texte

            // Envoyer l'email
            $mail->send();
            echo '<h3>Le message a été envoyé avec succès</h3>';
        } catch (Exception $e) {
            echo "<h3>Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}</h3>";
        }
    }
}