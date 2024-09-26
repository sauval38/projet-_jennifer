<?php

namespace Controllers;

use Models\ProductByGammeModels;
use Views\ProductByGammeViews;

class ProductByGammeControllers {
    protected $productsModels;
    protected $productsViews;

    public function __construct() {
        $this->productsModels = new ProductByGammeModels();
        $this->productsViews = new ProductByGammeViews();
    }

    public function showProductByGammes() {
        $id = $_GET['gammeId'];
        if ($id) {
            $products = $this->productsModels->getProductByGammes($id);
            $this->productsViews->displayProductByGammes($products);
        }
    }
}