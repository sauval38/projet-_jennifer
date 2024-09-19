<?php

namespace AdminControllers;

use AdminModels\AdminProductsModels;
use AdminModels\AdminProductImagesModels;
use AdminModels\AdminGammesModels;
use AdminViews\AdminProductFormViews;

class AdminProductsControllers {
    protected $productsModels;
    protected $productImagesModels;
    protected $gammesModels;
    protected $productFormViews;

    public function __construct() {
        $this->productsModels = new AdminProductsModels();
        $this->productImagesModels = new AdminProductImagesModels();
        $this->gammesModels = new AdminGammesModels();
        $this->productFormViews = new AdminProductFormViews();
    }

    public function showForm($id = null) {
        $gammes = $this->gammesModels->getAllGammes(); // Pour remplir le select des gammes
        if ($id) {
            $product = $this->productsModels->getProductById($id);
            $images = $this->productImagesModels->getImagesByProductId($id);
            if (!$product) {
                echo "Produit non trouvé";
                return;
            }
        } else {
            $images = '';
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

        $this->productFormViews->displayForm($product, $gammes, $images);
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
            // Gestion des images
            if (isset($_FILES['images'])) {
                $this->productImagesModels->saveImages($id, $_FILES['images']);
            }
            
            $_SESSION['message'] = "Produit modifiée avec succès!";
            header('Location: ../../products');
        } else {
            // Création d'un nouveau produit
            $id = $this->productsModels->createProduct($product_range_id, $name, $description, $price, $stock, $height, $weight);
    
            if ($id) {
                // Gestion des images
                if (isset($_FILES['images'])) {
                    $this->productImagesModels->saveImages($id, $_FILES['images']);
                }
    
                $_SESSION['message'] = "Produit créé avec succès!";
                header('Location: ../products');
            } else {
                // Gestion des erreurs lors de la création
                $_SESSION['message'] = "Erreur lors de la création du produit.";
                header('Location: ../products');
            }
        }
        exit;
    }

    public function deleteProduct($id) {
        // Récupérer les chemins des images associées au produit
        $images = $this->productImagesModels->getImagesByProductId($id);
    
        // Supprimer les fichiers du système de fichiers
        foreach ($images as $image) {
            $filePath = $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath); // Supprimer le fichier
            }
        }
    
        // Supprimer les enregistrements des images dans la base de données
        $this->productImagesModels->deleteImagesByProductId($id);
    
        // Supprimer le produit lui-même
        $this->productsModels->deleteProduct($id);
    
        $_SESSION['message'] = "Produit et ses images supprimés avec succès!";
        header('Location: ../../products');
        exit;
    }
    

    public function deleteImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $imageId = $_GET['image_id'] ?? null;
            $productId = $_GET['product_id'] ?? null;
    
            if ($imageId && $productId) {
                // Récupérer l'image de la base de données pour obtenir le chemin du fichier
                $image = $this->productImagesModels->getImageById($imageId);
    
                if ($image) {
                    // Supprimer l'image de la base de données
                    $this->productImagesModels->deleteImageById($imageId);
    
                    // Supprimer physiquement l'image du dossier
                    $imagePath = $image['image_path'];
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Supprime le fichier
                    }
    
                    // Rediriger vers le formulaire du produit
                    header('Location: ../../../../../admin/products/edit/' . $productId);
                    exit;
                }
            }
        }
    
        // Si quelque chose ne va pas, rediriger vers la page des produits
        header('Location: /admin/products');
        exit;
    }
    
}
