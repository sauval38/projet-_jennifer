<?php

namespace Views;

class HomeViews {
    public function body($carouselImages, $presentationAndGammesImages) {
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
                    <?php foreach ($carouselImages as $image) { ?>
                        <div class="carousel-slide">
                            <img src="<?php echo $image['image_path']; ?>" alt="<?php echo $image['informations']; ?>">
                        </div>
                    <?php } ?>
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
                <?php foreach ($presentationAndGammesImages as $image) { ?>
                    <?php if ($image['informations'] == 'image_presentation') { ?>
                        <section class="section-container">
                            <div class="text-block">
                                <h4>Une passion, une histoire</h4>
                            </div>
                            <div class="image-container">
                                <img src="<?php echo $image['image_path']; ?>" alt="Présentation">
                                <button class="button-link right" onclick="window.location.href='aboutMe'">PRÉSENTATION</button>
                            </div>
                        </section>
                        <div class="text-block">
                            <h4 id="text-middle">Un regard, un coup de foudre</h4>
                        </div>
                    <?php } elseif ($image['informations'] == 'image_gamme') { ?>
                        <section class="section-container">
                            <div class="image-container">
                                <img src="<?php echo $image['image_path']; ?>" alt="Gammes">
                                <button class="button-link right" onclick="window.location.href='gammes'">MES GAMMES</button>
                            </div>
                            <div class="text-block">
                                <h4>Une idée, une création</h4>
                            </div>
                        </section>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div id="products">
            <h3>Je vous présente quelques produits phares</h3>
            <div class="products-wrapper">
                <a href="http://localhost/code%20jennifer%20site/gammes/9" class="product">
                    <img src="./assets/images/home/_GMA3182-min.jpg" alt="">
                    <p>Corset</p>
                    <p>59.99 euro</p>
                </a>
                <div class="product">
                    <img src="./assets/images/home/DSC02815.jpg" alt="">
                    <p>Tasse KISS</p>
                    <p>59 euro</p>
                </div>
                <div class="product">
                    <img src="./assets/images/home/DSC02978.jpg" alt="">
                    <p>Duo mini-tasse</p>
                    <p>50 euro</p>
                </div>
            </div>
        </div>

        <script src="./assets/js/home.js"></script>
    <?php
    }
}
