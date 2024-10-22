<?php

namespace Controllers;

use Models\ProfileModels;
use Models\ProfileFormModels;
use Views\ProfileFormViews;

class ProfileFormControllers {
    protected $profileFormViews;
    protected $profileFormModels;
    protected $profileModels;

    public function __construct() {
        $this->profileFormViews = new ProfileFormViews();
        $this->profileFormModels = new ProfileFormModels(); 
        $this->profileModels = new ProfileModels(); 
    }

    public function profilFormControllers($user_id) {
        // Récupérer les données de l'utilisateur connecté
        $user_data = $this->profileModels->profilModels($user_id);
        // Passer les données à la vue
        $this->profileFormViews->profilFormViews($user_data);
    }

    public function updateProfile($user_id) {
        // Vérifier si les données sont envoyées via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $username = $_POST['username'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $firstname = $_POST['firstname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';

            // Mettre à jour le profil dans la base de données
            $updated = $this->profileFormModels->updateProfile($user_id, $username, $lastname, $firstname, $email, $phone_number);

            // Vérifier si la mise à jour a réussi
            if ($updated) {
                echo "<h1>Mise a jour réussi.</h1>";
                exit();
            } else {
                // Gérer l'erreur
                echo "<h1>Erreur lors de la mise à jour du profil.</h1>";
            }
        }
    }
}
