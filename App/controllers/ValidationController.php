<?php
// Déclare le namespace pour la classe ValidationController
namespace Controllers;

// Importation des classes ValidationModel et ValidationView des namespaces Models et Views
use Models\ValidationModel;
use Views\ValidationView;

// Définition de la classe ValidationController
class ValidationController {
    // Déclaration des propriétés protégées pour le modèle et la vue
    protected $validationModel;
    protected $validationView;

    // Constructeur de la classe ValidationController
    public function __construct() {
        // Instanciation du modèle ValidationModel
        $this->validationModel = new ValidationModel();
        // Instanciation de la vue ValidationView
        $this->validationView = new ValidationView();
    }

    // Méthode pour valider la commande
    public function orderValidate() {
        // Appel de la méthode prepareOrder du modèle pour préparer la commande
        $this->validationModel->prepareOrder();
    }

    // Méthode pour vérifier la commande
    public function orderCheck() {
        // Appel de la méthode initForm de la vue pour afficher le formulaire de vérification de commande
        $this->validationView->initForm();
    }
}
?>