<?php

namespace Controllers;

use Models\HomeModels;
use Views\HomeViews;

class HomeControllers {
    protected $homeViews;
    protected $homeModels;

    public function __construct() {
        $this->homeViews = new HomeViews();
        $this->homeModels = new HomeModels();
    }

    public function home() {
        // Récupérer les images du carrousel
        $carouselImages = $this->homeModels->getCarouselImages();
        
        // Récupérer les images de présentation et gammes
        $presentationAndGammesImages = $this->homeModels->getPresentationAndGammesImages();
        
        // Passer toutes les données à la vue
        $this->homeViews->body($carouselImages, $presentationAndGammesImages);
    }
}