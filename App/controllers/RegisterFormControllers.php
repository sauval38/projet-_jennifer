<?php
namespace Controllers;

use Models\RegisterFormModels;
use Views\RegisterFormViews;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterFormControllers {
    protected $registerFormmodels;
    protected $registerFormViews;
    protected $verifyEmailViews;

    public function __construct() {
        $this->registerFormmodels = new RegisterFormModels();
        $this->registerFormViews = new RegisterFormViews();
        
    }

    public function formRegisterController() {
        $this->registerFormViews->formRegisterViews();
    }

    public function userSaveController() {
        $token = $this->registerFormmodels->createUserModels();

        if ($token) {
            $email = $_POST['email-register'];
            // Envoyer un email de confirmation
            $this->sendVerificationEmail($email, $token);

            // Afficher un message ou rediriger l'utilisateur
            echo "<h3>Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception.</h3>";
        } else {
            echo "<h3>Erreur lors de l'enregistrement de l'utilisateur.</h3>";
        }
    }

    private function sendVerificationEmail($email, $token) {
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
            $mail->Subject = 'Confirmez votre email';
            $mail->Body    = "Cliquez sur ce lien pour vérifier votre email : <a href='http://localhost/projet-_jennifer/?action=verify&token=$token'>Confirmer votre email</a>";
            $mail->AltBody = "Cliquez sur ce lien pour vérifier votre email : http://localhost/projet-_jennifer/?action=verify&token=$token"; // Version texte

            // Envoyer l'email
            $mail->send();
            echo '<h3>Le message a été envoyé avec succès</h3>';
        } catch (Exception $e) {
            echo "<h3>Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}</h3>";
        }
    }

    public function verify() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            
            // Rechercher l'utilisateur avec le token
            $user = $this->registerFormmodels->getUserByToken($token);

            if ($user) {
                // Si l'utilisateur existe, valider l'email
                $this->registerFormmodels->verifyEmail($token);
                echo "<h3>Votre email a été confirmé. Vous pouvez maintenant vous connecter.</h3>";
            } else {
                echo "<h3>Lien de confirmation invalide ou expiré.</h3>";
            }
        } else {
            echo  "<h3>Aucun token fourni.</h3>";
        }
    }
}