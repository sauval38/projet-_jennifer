<?php

namespace Controllers;

use Views\HomeViews;

class HomeControllers{
    public function home() {
        $homeViews = new HomeViews();   

        $data = [
            'slide_1_image' => './assets/images/accueil.jpg',
            'slide_1_title' => 'Maison Héméra',
            'slide_1_image' => './assets/images/accueil_1.jpg',
            'slide_1_title' => 'Maison Héméra',
            'slide_1_image' => './assets/images/accueil_2.jpg',
            'slide_1_title' => 'Maison Héméra',
        ];

        $homeViews->body($data);
    }
}