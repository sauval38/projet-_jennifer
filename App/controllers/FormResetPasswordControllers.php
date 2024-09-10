<?php

namespace Controllers;

use Models\FormResetPasswordModels;
use Views\FormResetPasswordViews;

class FormResetPasswordControllers {
    protected $formResetPasswordModels;
    protected $formResetPasswordViews;

    public function __construct() {
        $this->formResetPasswordModels = new FormResetPasswordModels();
        $this->formResetPasswordViews = new FormResetPasswordViews();
    }

    public function showResetForm($token) {
        // Vérifie si le token est valide avant de montrer le formulaire
        $isValidToken = $this->formResetPasswordModels->validateToken($token);

        if ($isValidToken) {
            $this->formResetPasswordViews->showResetPasswordForm($token);
        } else {
            echo "<h3>Token invalide ou expiré</h3>";
        }
    }

    public function resetPassword() {
        if ($_POST['password'] === $_POST['confirm_password']) {
            $newPassword = $_POST['password'];
            $token = $_POST['token'];

            $resetStatus = $this->formResetPasswordModels->updatePassword($newPassword, $token);
            if ($resetStatus) {
                echo "<h3>Votre mot de passe a été réinitialisé avec succès !</h3>";
            } else {
                echo "<h3>Échec de la réinitialisation. Veuillez réessayer.</h3>";
            }
        } else {
            echo "<h3>Les mots de passe ne correspondent pas.</h3>";
        }
    }
}