<?php

namespace AdminControllers;

use AdminModels\AdminProductsModels;
use AdminModels\AdminGammesModels;
use AdminViews\AdminProductSearchViews;

class AdminProductSearchController {
    protected $productModels;
    protected $gammesModels;
    protected $productSearchViews;

    public function __construct() {
        $this->productModels = new AdminProductsModels();
        $this->gammesModels = new AdminGammesModels();
        $this->productSearchViews = new AdminProductSearchViews();
    }

    public function showProducts() {
        // Récupère toutes les gammes pour remplir le sélecteur
        $gammes = $this->gammesModels->getAllGammes();
        
        // Filtrage des produits selon la gamme sélectionnée
        $selectedRangeId = $_GET['product_range_id'] ?? null;
        $products = $this->productModels->getProductsByRange($selectedRangeId);

        // Affiche la vue avec les produits et les gammes
        $this->productSearchViews->displayProductList($products, $gammes, $selectedRangeId);
    }
}
