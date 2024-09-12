<?php

namespace Views;

class HomeViews {
    public function body() {
    ?>
        <h1>TOUT MES UNIVERS DANS UN SEUL MONDE</h1>
        <div class="carousel-container">
            <div class="carousel-side carousel-left">
                <h3>Chaque création raconte une histoire</h3>
                <img src="./assets/images/logo.png" alt="Logo">
                <h3>L'élégance artisanale à portée de main</h3>
            </div>
            <div class="carousel">
                <div class="carousel-wrapper">
                    <div class="carousel-slide">
                        <img src="assets/images/accueil.jpg" alt="Slide 1">
                    </div>
                    <div class="carousel-slide">
                        <img src="assets/images/accueil_1.jpg" alt="Slide 2">
                    </div>
                    <div class="carousel-slide">
                        <img src="assets/images/accueil_2.jpg" alt="Slide 3">
                    </div>
                </div>
            </div>
            <div class="carousel-side carousel-right">
                <h3>Des pièces d'exception façonnées à la main</h3>
                <img src="./assets/images/logo.png" alt="Logo">
                <h3>L'art de la céramique à votre portée</h3>
            </div>
        </div>

        <div id="contenu">
            <h3>Diplômée en 2014, je me suis lancée dans l'aventure de la céramique et j'ai créé Maison Héméra.</h3>
            <div class="content-wrapper">
                <div class="text-block">
                    <h3>Une passion, une histoire</h3>
                </div>
                <div class="image-container">
                    <img src="./assets/images/accueil_3.jpg" alt="accueil">
                    <a href="url-de-la-page.html" class="button-link left">PRÉSENTATION</a>
                </div>
                <div class="image-container">
                    <img src="./assets/images/accueil_4.jpg" alt="accueil">
                    <a href="url-de-la-page.html" class="button-link right">MES GAMMES</a>
                </div>
                <div class="text-block">
                    <h3>Une passion, une histoire</h3>
                </div>
            </div>
        </div>

        <script src="./assets/js/home.js"></script>
    <?php
    }
}
