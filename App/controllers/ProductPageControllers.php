<?php

namespace Controllers;

use Models\ProductPageModels;
use Views\ProductPageViews;

class ProductPageControllers {
    protected $productPageModels;
    protected $productPageViews;

    public function __construct() {
        $this->productPageModels = new ProductPageModels();
        $this->productPageViews = new ProductPageViews();
    }

    public function showProductPage() {
        $id = $_GET['productId'];
        
        if ($id) {
            // Récupérer les informations du produit
            $product = $this->productPageModels->getProductById($id);
            
            // Récupérer les images avec leurs options de couleur associées
            $images = $this->productPageModels->getImagesWithOptions($id);
            
            // Récupérer les options du produit (par exemple les couleurs disponibles)
            $productOptions = $this->productPageModels->getProductOptions($id);

            // Traduire les couleurs
            foreach ($productOptions as &$option) {
                if ($option['option_name'] === 'couleur') {
                    $option['option_value'] = $this->productPageModels->translateColor($option['option_value']);
                }
            }

            // Passer les données à la vue
            $this->productPageViews->displayProductPage($product, $images, $productOptions);
        }
    }
}
