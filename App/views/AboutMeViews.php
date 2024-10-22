<?php

namespace Views;

class AboutMeViews {
    public function aboutMeViews($aboutMeData, $statsData) {
        ?>
        <h1>A PROPOS DE MOI</h1>
        <?php if (!empty($aboutMeData)) : ?>
            <?php foreach ($aboutMeData as $data) : ?>

                <div id="about-me-section">
                    <div class="content-block">
                        <div class="about-me">
                            <div class="titre">
                                <h2>Je m'appelle Jennifer Blasco</h2>
                                <h2>Céramiste et tailleuse de pierre Iséroise</h2>
                            </div>
                            <img src="<?php echo htmlspecialchars($data['image_path']); ?>" alt="About me image">
                            <div class="titre">
                                <?php if (!empty($statsData)) : ?>
                                    <?php foreach ($statsData as $stat) : ?>
                                        <h2> <?php echo htmlspecialchars($stat['product_made']); ?> Produits fabriqués </h2> 
                                        <h2> <?php echo htmlspecialchars($stat['product_sell']); ?> Produits vendus </h2>
                                        <h2> <?php echo htmlspecialchars($stat['order_send']); ?> Commandes envoyées </h2>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <h2>Statistiques non disponibles</h2>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="bio">
                            <p><?php echo htmlspecialchars($data['bio']); ?></p>
                        </div>
                        <div class="divider"></div>
                        <div class="texte">
                            <p><strong>Artisanat de qualité supérieure :</strong></p>
                            <p><?php echo htmlspecialchars($data['text_1']); ?></p>
                            
                            <p><strong>Organisation et esthétique :</strong></p>
                            <p><?php echo htmlspecialchars($data['text_2']); ?></p>
                            
                            <p><strong>Élégance intemporelle :</strong></p>
                            <p><?php echo htmlspecialchars($data['text_3']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucune information disponible.</p>
        <?php endif; ?>
        <?php
    }
}
