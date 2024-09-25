<?php

namespace AdminControllers;

use AdminModels\AdminProductsModels;
use AdminModels\AdminProductImagesModels;
use AdminModels\AdminGammesModels;
use AdminModels\AdminProductOptionsModels; // Import du modèle des options
use AdminViews\AdminProductFormViews;

class AdminProductsControllers {
    protected $productsModels;
    protected $productImagesModels;
    protected $gammesModels;
    protected $productOptionsModels; // Ajout du modèle des options
    protected $productFormViews;

    public function __construct() {
        $this->productsModels = new AdminProductsModels();
        $this->productImagesModels = new AdminProductImagesModels();
        $this->gammesModels = new AdminGammesModels();
        $this->productOptionsModels = new AdminProductOptionsModels(); // Instanciation du modèle des options
        $this->productFormViews = new AdminProductFormViews();
    }

    public function showForm($id = null) {
        $gammes = $this->gammesModels->getAllGammes(); // Pour remplir le select des gammes
        $colors = $this->productOptionsModels->getColors(); // Récupérer les couleurs disponibles
        $productOptions = [];
        $selectedColors = []; // Pour stocker les couleurs sélectionnées associées au produit
        $imageColors = []; // Tableau pour stocker les couleurs associées aux images
    
        if ($id) {
            $product = $this->productsModels->getProductById($id);
            $images = $this->productImagesModels->getImagesByProductId($id);
            $productOptions = $this->productOptionsModels->getOptionsByProductId($id); // Récupérer les options de produit
            
            // Récupérer uniquement les couleurs sélectionnées pour ce produit
            $selectedColors = $this->productOptionsModels->getProductColors($id);
            $selectedColors = array_column($selectedColors, 'option_value'); // Obtenir les valeurs des couleurs
            
            // Associer les couleurs aux images
            foreach ($images as $image) {
                // Récupérer la couleur associée à l'image
                $color = $this->productOptionsModels->getColorByOptionId($image['product_option_id']);
                if ($color) {
                    $imageColors[$image['id']] = $color; // Associer l'ID de l'image à sa couleur
                }
            }
            
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
    
        // Passer également les couleurs des images à la vue
        $this->productFormViews->displayForm($product, $gammes, $images, $colors, $productOptions, $selectedColors, $imageColors);
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
        $selectedColors = $_POST['colors'] ?? []; // Récupération des couleurs sélectionnées
        $imageOptions = $_POST['image_options'] ?? []; // Options associées aux images
    
        // Récupérer toutes les couleurs disponibles une seule fois
        $availableColors = $this->productOptionsModels->getColors();
    
        if ($id) {
            // Mise à jour du produit
            $this->productsModels->updateProduct($id, $product_range_id, $name, $description, $price, $stock, $height, $weight);
            
            // Gestion des images et des options associées
            if (isset($_FILES['images'])) {
                $this->productImagesModels->saveImages($id, $_FILES['images'], $imageOptions);
            }
    
            // Mise à jour des options (ici couleurs)
            $this->productOptionsModels->deleteOptionsByProductId($id);
            foreach ($selectedColors as $colorId) {
                // Recherche de la couleur dans le tableau des couleurs disponibles
                $color = array_filter($availableColors, function($c) use ($colorId) {
                    return $c['id'] == $colorId;
                });
    
                if (!empty($color)) {
                    $color = array_shift($color);
                    $this->productOptionsModels->saveProductOptions($id, 'couleur', $color['name']);
                }
            }
    
            // Mise à jour des options d'images
            foreach ($imageOptions as $imageId => $colorId) {
                // Récupérer la product_option_id à partir de product_id et colorId
                $productOptionId = $this->productOptionsModels->getProductOptionId($id, $colorId);
                if ($productOptionId) {
                    $this->productImagesModels->updateImageOption($imageId, $productOptionId);
                }
            }
    
            $_SESSION['message'] = "Produit modifié avec succès!";
            header('Location: ../../products');
        } else {
            // Création d'un nouveau produit
            $id = $this->productsModels->createProduct($product_range_id, $name, $description, $price, $stock, $height, $weight);
    
            if ($id) {
                // Gestion des images et des options associées
                if (isset($_FILES['images'])) {
                    $this->productImagesModels->saveImages($id, $_FILES['images'], $imageOptions);
                }
    
                // Enregistrement des options (couleurs)
                foreach ($selectedColors as $colorId) {
                    $color = array_filter($availableColors, function($c) use ($colorId) {
                        return $c['id'] == $colorId;
                    });
    
                    if (!empty($color)) {
                        $color = array_shift($color);
                        $this->productOptionsModels->saveProductOptions($id, 'couleur', $color['name']);
                    }
                }
    
                $_SESSION['message'] = "Produit créé avec succès!";
                header('Location: ../products');
            } else {
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
