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
            $product = $this->productPageModels->getProductById($id);
            $this->productPageViews->displayProductPage($product);
        }
    }
}