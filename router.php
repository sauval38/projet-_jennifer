<?php
require_once('vendor/autoload.php');

use App\Database;

use Controllers\FormForgotPasswordControllers;
use Controllers\FormResetPasswordControllers;
use Controllers\GeneralConditionsSaleControllers;
use Controllers\HomeControllers;
use Controllers\LoginFormControllers;
use Controllers\PrivacyPolicyControllers;
use Controllers\RegisterFormControllers;
use Controllers\GammesControllers;
use AdminControllers\AdminDashboardControllers;
use AdminControllers\AdminGammesControllers;

$pdo = new Database;

$step = $_REQUEST['step'] ?? null;
$action = $_REQUEST['action'] ?? null;
$crud = $_REQUEST['crud'] ?? null;
$id = $_REQUEST['id'] ?? null;
$formType = $_POST['form_type'] ?? '';

switch ($action) {
    default:
        $homeControllers = new HomeControllers();
        $homeControllers->home();
        break;
    
    case 'gammes':
        $gammesControllers = new GammesControllers();
        $gammesControllers->showGammes();
        break;

    case 'login':
        $loginFormControllers = new LoginFormControllers();
        $registerFormController = new RegisterFormControllers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($formType === 'login') {
                $loginFormControllers->showLoginForm();
            } elseif ($formType === 'register') {
                $registerFormController->userSaveController();
            }
        } else {
            $loginFormControllers->formLoginController();
            $registerFormController->formRegisterController();
        }
        break;

    case 'verify':
        $registerFormController = new RegisterFormControllers();
        $registerFormController->verify(); // Appelle la méthode verify() pour valider l'email
        break;
    
    case 'password':
        $formResetPasswordControllers = new FormResetPasswordControllers();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formResetPasswordControllers->resetPassword();
        } else {
            if (isset($_GET['token'])) {
                $token = $_GET['token'];
                $formResetPasswordControllers->showResetForm($token);
            } else {
                echo "<h1>Token manquant</h1>";
            }
        }
        break;

    case 'logout':
        $loginFormControllers = new LoginFormControllers();
        $loginFormControllers->logout();
        break;    

    case 'forgot-password':
            $formForgotPasswordControllers = new FormForgotPasswordControllers();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $formForgotPasswordControllers->getEmailByUser();
            } else {
                $formForgotPasswordControllers->FormForgotPassword();
            }
        break;
        
    case 'admin':
        $adminDashboardControllers = new AdminDashboardControllers();
        if (!$step){
            $adminDashboardControllers->showAdminBoard();
        } else {
            switch ($step) {
            case 'gammes':
                $adminGammesController = new AdminGammesControllers();
                $gammesControllers = new GammesControllers();

                switch ($crud) {
                    case 'create':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $adminGammesController->handleFormSubmission();
                        } else {
                            $adminGammesController->showForm();
                        }
                        break;
                    
                    case 'edit':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $adminGammesController->handleFormSubmission();
                        } else {
                            $adminGammesController->showForm($id);
                        }
                        break;

                    case 'delete':
                        if ($id) {
                            $adminGammesController->deleteGamme($id);
                        } else {
                            echo "ID manquant pour la suppression.";
                        }
                        break;

                    default:
                        $gammesControllers->showAdminGammes();
                        break;
                }
                break;
        }
        }
        
        
        break;
        
    case 'privacy':
        $privacyPolicyControllers = new PrivacyPolicyControllers();
        $privacyPolicyControllers->privacyPolicyController();
        break;

    case 'general-condition':
        $generalConditionsSaleControllers = new GeneralConditionsSaleControllers();
        $generalConditionsSaleControllers->generalConditionController();
        break;    
}
