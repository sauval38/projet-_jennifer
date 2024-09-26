<?php

namespace Views;

class ProductPageViews {

    public function displayProductPage($product, $images, $productOptions) {
        ?>
        <div class="product-page-container">
            <!-- Carrousel d'images à gauche -->
            <div class="carousel-container">
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
            </div>

            <!-- Fiche produit à droite -->
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Prix :</strong> <?php echo htmlspecialchars($product['price']); ?> €</p>
                <p><strong>Taille :</strong> <?php echo htmlspecialchars($product['height']); ?> cm</p>
                <p><strong>Stock :</strong> <?php echo htmlspecialchars($product['stock']); ?> pièces disponibles</p>
                <p><strong>Poids :</strong> <?php echo htmlspecialchars($product['weight']); ?> kg</p>

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
                <div class="add-to-cart">
                    <a href="cart/add/<?php echo $product['id']; ?>" class="btn btn-primary">Ajouter au panier</a>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.color-square').forEach(function(square) {
                square.addEventListener('click', function() {
                    // Obtenir l'ID de la couleur sélectionnée
                    var selectedColorId = this.getAttribute('data-color-id');

                    // Masquer toutes les images
                    document.querySelectorAll('.carousel-image').forEach(function(image) {
                        image.style.display = 'none';
                    });

                    // Afficher les images correspondantes à la couleur sélectionnée
                    var colorImages = document.querySelectorAll('.carousel-image[data-option-id="' + selectedColorId + '"]');
                    if (colorImages.length > 0) {
                        colorImages.forEach(function(image) {
                            image.style.display = 'block';
                        });
                    } else {
                        // Si aucune image ne correspond, afficher l'image par défaut
                        document.getElementById('default-image').style.display = 'block';
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.querySelector('.carousel-wrapper');
                const slides = document.querySelectorAll('.carousel-slide');
                const totalSlides = slides.length;
                let currentIndex = 0;
                const intervalTime = 5000; // Temps entre chaque changement de diapositive (en millisecondes)

                function showSlide(index) {
                    if (index >= totalSlides) {
                        currentIndex = 0;
                    } else if (index < 0) {
                        currentIndex = totalSlides - 1;
                    } else {
                        currentIndex = index;
                    }
                    const offset = -currentIndex * 100;
                    wrapper.style.transform = `translateX(${offset}%)`;
                }

                function nextSlide() {
                    showSlide(currentIndex + 1);
                }

                function startAutoSlide() {
                    setInterval(nextSlide, intervalTime);
                }

                // Initialiser le carrousel
                showSlide(currentIndex);
                startAutoSlide();
            });

        </script>

        <style>
            .product-page-container {
                display: flex;
                gap: 20px;
            }

            .carousel-container {
                display: flex;
                flex-direction: row;
                align-items: center;
                width: 50%;
            }

            .carousel-slide {
                padding: 20px;
                background-color: red;
            }

            .carousel {
                flex: 1;
                overflow: hidden;
                position: relative;
                margin-left: 10px; /* Espacement entre le carrousel latéral et le carrousel principal */
            }

            .carousel-wrapper {
                display: flex;
                transition: transform 0.5s ease-in-out;
            }


            .carousel-slide img {
                object-fit: cover; 
                width: 100%;
                height: 100px; /* Hauteur réduite pour les images du carrousel */
                border: 1px solid #ccc; /* Bordure pour les images */
                display: block;
            }

            .product-info {
                width: 50%;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .product-colors {
                margin-top: 20px;
            }

            .color-options {
                display: flex;
                gap: 10px;
            }

            .color-square {
                width: 40px;
                height: 40px;
                border: 1px solid #000;
                cursor: pointer;
            }

            .color-square:hover {
                opacity: 0.8;
            }

            .add-to-cart {
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #28a745;
                color: #fff;
                border: none;
                cursor: pointer;
                border-radius: 5px;
            }

            .add-to-cart:hover {
                background-color: #218838;
            }
        </style>
        <?php
    }
}
