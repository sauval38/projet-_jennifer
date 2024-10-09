<?php
// Déclare le namespace pour la classe CartController
namespace Controllers;

// Importation de la classe CartModel du namespace Models
use Models\CartModel;

// Définition de la classe CartController
class CartController {

    // Méthode pour ajouter un article au panier
    public function addToCart() {
        // Définir le type de contenu de la réponse en JSON
        header('Content-Type: application/json');

        // Récupérer les données JSON de la requête
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Vérifier si les données sont correctement récupérées
        if (isset($data['product_id']) && isset($data['quantity'])) {
            $product_id = $data['product_id'];
            $price = $data['price'];
            $quantity = $data['quantity'];
            $product_option_id = $data['product_option_id'];
            
            // Appeler la méthode du modèle pour ajouter l'élément au panier
            $cartModel = new CartModel();
            $result = $cartModel->addItemToCart($price, $product_id, $quantity, $product_option_id);

            // Vérifier le résultat de l'opération et renvoyer une réponse JSON appropriée
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Item added to cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add item to cart']);
            }
        } else {
            // Renvoie une réponse JSON en cas de données invalides
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
    }

    // Méthode pour ajuster la quantité d'un article dans le panier
    public function adjustQuantity() {
        // Récupérer les données JSON de la requête
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
    
        // Vérifier si les données sont correctement récupérées
        if (isset($data['product_id']) && isset($data['quantity'])) {
            $productId = $data['product_id'];
            $quantity = $data['quantity'];
            $cartId = $data['cart_id'];
            $_SESSION['cart_id'] = $cartId;
    
            // Appeler la méthode du modèle pour ajuster la quantité
            $cartModel = new CartModel();
            $result = $cartModel->updateProductQuantity($cartId, $productId, $quantity);
    
            // Vérifier le résultat de l'opération et renvoyer une réponse JSON appropriée
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Quantity adjusted']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to adjust quantity']);
            }
        } else {
            // Renvoie une réponse JSON en cas de données invalides
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
    }

    // Méthode pour supprimer un article du panier
    public function removeFromCart() {
        // Récupérer les données JSON de la requête
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
    
        // Vérifier si les données sont correctement récupérées
        if (isset($data['product_id'])) {
            $productId = $data['product_id'];
            $cartId = $data['cart_id'];
            $_SESSION['cart_id'] = $cartId;
    
            // Appeler la méthode du modèle pour supprimer le produit du panier
            $cartModel = new \Models\CartModel();
            $result = $cartModel->removeProductFromCart($cartId, $productId);
    
            // Vérifier le résultat de l'opération et renvoyer une réponse JSON appropriée
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Product removed from cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove product from cart']);
            }
        } else {
            // Renvoie une réponse JSON en cas de données invalides
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
    }
}
?>