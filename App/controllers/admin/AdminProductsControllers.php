<?php

namespace AdminControllers;

use AdminModels\AdminProductsModels;
use AdminModels\AdminGammesModels;
use AdminViews\AdminProductFormViews;

class AdminProductsControllers {
    protected $productsModels;
    protected $gammesModels;
    protected $productFormViews;

    public function __construct() {
        $this->productsModels = new AdminProductsModels();
        $this->gammesModels = new AdminGammesModels();
        $this->productFormViews = new AdminProductFormViews();
    }

    public function showForm($id = null) {
        $gammes = $this->gammesModels->getAllGammes(); // Pour remplir le select des gammes
        if ($id) {
            $product = $this->productsModels->getProductById($id);
            if (!$product) {
                echo "Produit non trouvé";
                return;
            }
        } else {
            $product = [
                'id' => '',
                'product_range_id' => '',
                'name' => '',
                'description' => '',
                'price' => '',
                'stock' => '',
                'height' => '',
                'weight' => ''
            ];
        }

        $this->productFormViews->displayForm($product, $gammes);
    }

    public function handleFormSubmission() {
        $id = $_POST['id'] ?? null;
        $product_range_id = $_POST['product_range_id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $stock = $_POST['stock'] ?? '';
        $height = $_POST['height'] ?? '';
        $weight = $_POST['weight'] ?? '';

        if ($id) {
            $this->productsModels->updateProduct($id, $product_range_id, $name, $description, $price, $stock, $height, $weight);
            $_SESSION['message'] = "Produit modifiée avec succès!";
            header('Location: ../../products');
        } else {
            $this->productsModels->createProduct($product_range_id, $name, $description, $price, $stock, $height, $weight);
            $_SESSION['message'] = "Produit créée avec succès!";
            header('Location: ../products');
        }
        exit;
    }

    public function deleteProduct($id) {
        $this->productsModels->deleteProduct($id);
        $_SESSION['message'] = "Produit supprimée avec succès!";
        header('Location: ../../products');
        exit;
    }
}
