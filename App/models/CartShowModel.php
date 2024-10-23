<?php

namespace Models;

use App\Database;

class CartShowModel {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getCartItems($userId) {
        $stmt = $this->db->prepare("
            SELECT cd.id AS cart_detail_id, cd.cart_id, p.name, p.price, p.weight, po.option_value AS color, pi.image_path, cd.quantity
            FROM cart_detail cd
            JOIN cart c ON c.id = cd.cart_id
            JOIN products p ON p.id = cd.product_id
            JOIN product_option po ON po.id = cd.product_option_id
            JOIN product_images pi ON pi.product_option_id = cd.product_option_id
            WHERE c.user_id = :userId
        ");
        $stmt->bindParam(':userId', $userId);
        
        if ($stmt->execute()) {
            $cartItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!empty($cartItems)) {
                // On récupère le cart_id du premier élément, car tous les items appartiennent au même panier
                $_SESSION['cart_id'] = $cartItems[0]['cart_id'];
            }
            return $cartItems;
        } else {
            // Si la requête échoue, retourner un tableau vide ou gérer l'erreur comme souhaité
            return [];
        }
    }
    
    public function updateItemQuantity($cartDetailId, $quantity) {
        $stmt = $this->db->prepare("
            UPDATE cart_detail 
            SET quantity = :quantity 
            WHERE id = :cartDetailId
        ");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':cartDetailId', $cartDetailId);
        return $stmt->execute();
    }

    public function removeItemFromCart($cartDetailId) {
        $stmt = $this->db->prepare("
            DELETE FROM cart_detail 
            WHERE id = :cartDetailId
        ");
        $stmt->bindParam(':cartDetailId', $cartDetailId);
        return $stmt->execute();
    }
}
