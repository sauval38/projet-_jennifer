<?php

namespace Controllers;

use Models\LoginFormModels;
use Views\LoginFormViews;

class LoginFormControllers {
    protected $loginFormModels;
    protected $loginFormViews;

    public function __construct() {
        $this->loginFormModels = new LoginFormModels();
        $this->loginFormViews = new LoginFormViews();
    }

    public function formLoginController() {
        $this->loginFormViews->formloginViews();
    }
    
    public function showLoginForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email-login'];
            $password = $_POST['password-login'];
            $authenticated = $this->loginFormModels->authenticate($email, $password);

            if ($authenticated) {
                header('location: ./');
            } else {
                echo "<h3>Échec de la connexion. Veuillez verifier vos identifiants.</h3>";
            }
        }
    }

    public function logout() {
        session_unset();
        header("Location: index.php");
        exit();
    }
}