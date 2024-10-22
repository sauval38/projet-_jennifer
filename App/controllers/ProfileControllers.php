<?php

namespace Controllers;

use Views\ProfileViews;
use Models\ProfileModels;

class ProfileControllers {
    protected $profileViews;
    protected $profileModels;

    public function __construct() {
        $this->profileViews = new ProfileViews();
        $this->profileModels = new ProfileModels();
    }

    public function profilControllers() {

        if (isset($_SESSION['id'])) { // Vérifiez si l'ID de l'utilisateur est défini
            $user_id = $_SESSION['id']; // Utilisez 'id' au lieu de 'user_id'
            $user_data = $this->profileModels->profilModels($user_id); // Récupérer les données de l'utilisateur connecté
            $this->profileViews->profileViews($user_data); // Transmettre les données à la vue
        } else {
            echo '<h1>Vous devez être connecté pour voir votre profil.</h1>';
        }
    }
}
