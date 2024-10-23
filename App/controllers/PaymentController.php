<?php
// Déclare le namespace pour la classe PaymentController
namespace Controllers;

// Importation des classes PaymentModel et PaymentView des namespaces Models et Views
use Models\PaymentModel;
use Views\PaymentView;

// Définition de la classe PaymentController
class PaymentController {
    // Déclaration des propriétés protégées pour le modèle et la vue
    protected $paymentModel;
    protected $paymentView;

    // Constructeur de la classe PaymentController
    public function __construct() {
        // Instanciation du modèle PaymentModel
        $this->paymentModel = new PaymentModel();
        // Instanciation de la vue PaymentView
        $this->paymentView = new PaymentView();
    }

    // Méthode pour afficher les options de paiement
    public function PaymentChoice() {
        // Récupération des options de paiement depuis le modèle
        $paymentOptions = $this->paymentModel->fetchPaymentOpt();
        // Appel de la méthode initForm de la vue pour afficher les options de paiement
        $this->paymentView->initForm($paymentOptions);

        // Vérification si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Appel de la méthode pour sauvegarder l'option de paiement sélectionnée
            $this->PaymentSave();
        }
    }

    // Méthode pour sauvegarder l'option de paiement sélectionnée
    public function PaymentSave() {
        // Vérification si une option de paiement a été sélectionnée
        if (isset($_POST['payment_name'])) {
            // Enregistrement de l'option de paiement sélectionnée dans la session
            $_SESSION['selected_payment'] = $_POST['payment_name'];
            // Redirection vers la page de vérification de la commande
            header('Location: check-validation');
            exit();
        } else {
            // Affichage d'un message d'erreur si aucune option de paiement n'a été sélectionnée
            echo "No payment option selected.";
        }
    }
}
?>