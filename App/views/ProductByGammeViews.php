<?php

namespace Views;

class ProductByGammeViews {
    public function displayProductByGammes($products) {
        $gammeId = $_GET['gammeId'];
        ?>
        <div class="products-container">
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <a href="gammes/<?php echo htmlspecialchars($gammeId);?>/<?php echo htmlspecialchars($product['id']); ?>">
                        <div class="gamme-item">
                            <figure>
                                <!-- Affiche la première image du produit -->
                                <img loading="lazy" src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                                <figcaption>
                                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                </figcaption>
                            </figure>
                            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun produit disponible.</p>
            <?php endif; ?>
        </div>
        <?php
    }
}
    