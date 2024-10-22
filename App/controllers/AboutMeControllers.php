<?php

namespace Controllers;

use Models\AboutMeModels;
use Views\AboutMeViews;

class AboutMeControllers {
    protected $aboutMeViews;
    protected $aboutMeModels;

    public function __construct() {
        $this->aboutMeViews = new AboutMeViews();
        $this->aboutMeModels = new AboutMeModels(); // Charger le modèle
    }
    
    public function aboutMeControllers() {
        // Récupérer les données de la table 'about_me'
        $aboutMeData = $this->aboutMeModels->aboutMeModels();
        
        // Récupérer les données de la table 'general_stats'
        $statsData = $this->aboutMeModels->statsModels();
        
        // Passer les deux types de données à la vue
        $this->aboutMeViews->aboutMeViews($aboutMeData, $statsData);
    }
}
