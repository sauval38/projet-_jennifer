<?php

namespace Views;

class ProductPageViews {

    public function displayProductPage($product, $images, $productOptions) {
        ?>
        <div class="product-page-container">
            <!-- Carrousel d'images à gauche -->
            <div class="carousel-container">
                <button id="prev-button" class="carousel-button">&lt;</button>
                <div class="carousel">
                    <div class="carousel-wrapper">
                        <?php foreach ($images as $image) : ?>
                            <div class="carousel-slide">
                                <img src="<?php echo $image['image_path']; ?>" 
                             alt="Product Image" 
                             class="carousel-image" 
                             data-option-id="<?php echo $image['product_option_id']; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button id="next-button" class="carousel-button">&gt;</button>
            </div>

            <!-- Fiche produit à droite -->
            <div class="product-info">
                <h1 data-product-id="<?php echo htmlspecialchars($product['id']); ?>"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Prix :</strong> <?php echo htmlspecialchars($product['price']); ?> €</p>
                <p><strong>Taille :</strong> <?php echo htmlspecialchars($product['height']); ?> cm</p>
                <p><strong>Stock :</strong> <?php echo htmlspecialchars($product['stock']); ?> pièces disponibles</p>
                <p><strong>Poids :</strong> <?php echo htmlspecialchars($product['weight']); ?> kg</p>

                <!-- Champ de sélection de la quantité -->
                <div class="product-quantity">
                    <label for="quantity"><strong>Quantité :</strong></label>
                    <input type="number" id="quantity" class="qte" name="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>">
                </div>

                <!-- Couleurs disponibles pour le produit -->
                <div class="product-colors">
                    <h3>Couleurs disponibles :</h3>
                    <div class="color-options">
                        <?php foreach ($productOptions as $option) : ?>
                            <?php if ($option['option_name'] === 'couleur') : ?>
                                <div class="color-square" 
                                    style="background-color: <?php echo htmlspecialchars($option['option_value']); ?>;" 
                                    data-color-id="<?php echo $option['id']; ?>"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Lien Ajouter au panier -->
                <button type="button" class="add-to-cart">Ajouter au Panier</button>
            </div>

        </div>

        <script src="./assets/js/productPage.js"></script>
        <script src="./assets/js/addToCart.js"></script>
        <?php
    }
}
