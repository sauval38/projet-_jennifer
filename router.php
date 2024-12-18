<?php

require_once('vendor/autoload.php');

use App\Database;

use AdminControllers\AdminAboutMeControllers;
use AdminControllers\AdminDashboardControllers;
use AdminControllers\AdminGammesControllers;
use AdminControllers\AdminProductsControllers;
use AdminControllers\AdminProductSearchController;
use AdminControllers\AdminHomeControllers;
use AdminControllers\AdminHomeFormControllers;
use AdminControllers\AdminColorsControllers;
use AdminControllers\AdminAddColorsControllers;
use Controllers\AboutMeControllers;
use Controllers\ContactControllers;
use Controllers\FormForgotPasswordControllers;
use Controllers\FormResetPasswordControllers;
use Controllers\GeneralConditionsSaleControllers;
use Controllers\HomeControllers;
use Controllers\LoginFormControllers;
use Controllers\PrivacyPolicyControllers;
use Controllers\ProfileControllers;
use Controllers\ProfileFormControllers;
use Controllers\RegisterFormControllers;
use Controllers\GammesControllers;
use Controllers\ProductByGammeControllers;
use Controllers\CartController;
use Controllers\ProductPageControllers;
use Controllers\CartShowController;
use Controllers\AddressCartController;
use Controllers\DeliveryCartController;
use Controllers\RecapOrderController;
use Controllers\PaymentController;
use Controllers\ValidationController;

$pdo = new Database;

// Vérifiez si la session est déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['role'] = $_SESSION['role'] ?? null;
$step = $_REQUEST['step'] ?? null;
$action = $_REQUEST['action'] ?? null;
$crud = $_REQUEST['crud'] ?? null;
$id = $_REQUEST['id'] ?? null;
$gammeId = $_REQUEST['gammeId'] ?? null;
$productId = $_REQUEST['productId'] ?? null;
$formType = $_POST['form_type'] ?? '';
$userId = $_SESSION['id'] ?? null;

switch ($action) {
    default:
        $homeControllers = new HomeControllers();
        $homeControllers->home();
        break;

    case 'gammes':
        if ($gammeId) {
            if ($productId) {
                $productPageControllers = new ProductPageControllers();
                $productPageControllers->showProductPage();
            } else {
                $productsByGammeControllers = new ProductByGammeControllers();
                $productsByGammeControllers->showProductByGammes($id);
            }
        } else {
            $gammesControllers = new GammesControllers();
            $gammesControllers->showGammes();
        }
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
        $registerFormController->verify();
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
        if (isset($_SESSION['is_logged_in']) && $_SESSION['role'] == "ADMIN") {
            $adminDashboardControllers = new AdminDashboardControllers();
            if (!$step) {
                $adminDashboardControllers->showAdminBoard();
            } else {
                switch ($step) {
                    case 'gammes':
                        $adminGammesController = new AdminGammesControllers();
                        $gammesControllers = new GammesControllers();

                        switch ($crud) {
                            case 'create':
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

                    case 'products':
                        $adminProduitsController = new AdminProductsControllers();
                        $produitsControllers = new AdminProductSearchController();

                        switch ($crud) {
                            case 'create':
                            case 'edit':
                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                    $adminProduitsController->handleFormSubmission();
                                } else {
                                    $adminProduitsController->showForm($id);
                                }
                                break;

                            case 'delete':
                                if ($id) {
                                    $adminProduitsController->deleteProduct($id);
                                } else {
                                    echo "ID manquant pour la suppression.";
                                }
                                break;

                            case 'deleteImage':
                                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                    $adminProduitsController->deleteImage();
                                } else {
                                    echo "Action non autorisée.";
                                }
                                break;

                            default:
                                $produitsControllers->showProducts();
                                break;
                        }
                        break;

                        case 'aboutMe':
                            $adminAboutMeControllers = new AdminAboutMeControllers();
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $adminAboutMeControllers->updateAboutMe();
                            } else {
                                $adminAboutMeControllers->showAboutMe();
                            }
                            break;

                        case 'colors':
                            $adminColorsControllers = new AdminColorsControllers();
                            $adminColorsControllers->AdminColorsControllers();
                            break;

                        case 'add-color':
                            $adminAddColorsControllers = new AdminAddColorsControllers();
                            $adminAddColorsControllers->AddColorsControllers(); 
                            break;   

                    case 'home':    
                        $adminHomeControllers = new AdminHomeControllers();
                        $adminHomeFormControllers = new AdminHomeFormControllers();
                        
                        switch ($crud) {
                            case 'modification':
                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                    if (isset($_FILES['image'])) {
                                        $adminHomeFormControllers->uploadImage();
                                    } else {
                                        $adminHomeFormControllers->homeFormAdminControllers();
                                    }
                                } else {
                                    $adminHomeControllers->adminImageControllers(); 
                                }
                                break;
                        
                            default:
                                $adminHomeControllers->adminImageControllers();
                                break;
                        }
                        break;
            }
        }
        break;
    }
    case 'commande':
    if (!isset($_SESSION['id'])) {
        header('Location: ../login');
        exit();
    } else {
        $step = $_REQUEST['step'] ?? null;
        switch ($step) {
            case 'adresse':
                $addressCartController = new AddressCartController();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($addressCartController->AddressSave()) {
                        header("Location: ./livraison");
                        exit();
                    } else {
                        $addressCartController->AddressForm();
                    }
                } else {
                    $addressCartController->AddressForm();
                }
                break;
            case 'livraison':
                $deliveryCartController = new DeliveryCartController();
                $deliveryCartController->DeliveryChoice();
                break;
            case 'recap':
                $recapOrder = new RecapOrderController();
                $cart_id = $_SESSION['cart_id'];
                $recapOrder->RecapPlz($cart_id);
                break;
            case 'paiement':
                // Etape 'paiement'
                $paymentController = new PaymentController();
                $paymentController->PaymentChoice();
                break;
            case 'check-validation':
                // Etape 'check-validation'
                $validationController = new ValidationController();
                $validationController->orderCheck();
                break;
            case 'validation':
                // Etape 'validation'
                $validationController = new ValidationController();
                $validationController->orderValidate();
                break;
        }
    }
        break;

    case 'profile':
        $profileControllers = new ProfileControllers();
        $profileControllers->profilControllers();
        break;   
            
    case 'update_profile':
        $profileFormControllers = new ProfileFormControllers();
        $user_id = $_SESSION['id']; // Supposant que l'ID de l'utilisateur est stocké dans la session
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileFormControllers->updateProfile($user_id);
        } else {
            $profileFormControllers->profilFormControllers($user_id);
        }
        break; 

    case 'aboutMe':
        $aboutMeControllers = new AboutMeControllers();
        $aboutMeControllers->aboutMeControllers();
        break;

    case 'contact':
        $contactControllers = new ContactControllers();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactControllers->sendMessage();
        } else {
            $contactControllers->Contact();
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
        
    case 'panier':
        if ($userId) {
            $cartShowController = new CartShowController();
            $cartShowController->displayCart($userId);
        } else {
            echo '<h1>Veuillez vous <a href="login">connecter</a> pour acceder à votre panier</h1>';
        }
        
        break;
    
    case 'update-quantity':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log('Updating quantity'); // Log pour voir si cette partie du code est atteinte
            $data = json_decode(file_get_contents('php://input'), true);
            $cartDetailId = $data['cartDetailId'];
            $quantity = $data['quantity'];

            $cartShowController = new CartShowController();
            $cartShowController->updateQuantity($cartDetailId, $quantity);
        } else {
            error_log('Invalid request method for update-quantity'); // Log si la méthode n'est pas POST
        }
        break;

    case 'remove-item':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log('Removing item'); // Log pour voir si cette partie du code est atteinte
            $data = json_decode(file_get_contents('php://input'), true);
            $cartDetailId = $data['cartDetailId'];

            $cartShowController = new CartShowController();
            $cartShowController->removeItem($cartDetailId);
        } else {
            error_log('Invalid request method for remove-item'); // Log si la méthode n'est pas POST
        }
        break;


    case 'addToCart':
        // Cas où l'action est 'addToCart' pour ajouter un produit au panier
        $cartController = new CartController();
        $cartController->addToCart();
        break;

    case 'adjustQuantity':
        // Cas où l'action est 'adjustQuantity' pour ajuster la quantité d'un produit dans le panier
        $cartController = new CartController();
        $cartController->adjustQuantity();
        break;

    case 'removeFromCart':
        // Cas où l'action est 'removeFromCart' pour retirer un produit du panier
        $cartController = new CartController();
        $cartController->removeFromCart();
        break;
}
