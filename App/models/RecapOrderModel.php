<?php
namespace Models;

use App\Database;

class RecapOrderModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function fetchCartDetails($cartId) {
        try {
            $pdo = $this->db->getConnection()->prepare(
                "SELECT cd.product_id, cd.quantity, p.name, p.price, pi.image_path, po.option_value AS color
                 FROM cart_detail cd
                 JOIN products p ON cd.product_id = p.id
                 LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.product_option_id = cd.product_option_id
                 LEFT JOIN product_option po ON po.id = cd.product_option_id
                 WHERE cd.cart_id = ?"
            );
            $pdo->execute([$cartId]);
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des détails du panier : " . $e->getMessage();
            return [];
        }
    }

    public function getSelectedDeliveryOption() {
        $deliveryOptionId = $_SESSION['delivery_option_id'] ?? null;
        if ($deliveryOptionId) {
            try {
                $pdo = $this->db->getConnection()->prepare("SELECT id, name, price FROM delivery_option WHERE id = ?");
                $pdo->execute([$deliveryOptionId]);
                return $pdo->fetch(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                echo "Erreur lors de la récupération de l'option de livraison : " . $e->getMessage();
                return null;
            }
        }
        return null;
    }

    public function calculateTotalAmount($cartDetails, $deliveryOption) {
        $total = 0;
        foreach ($cartDetails as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($deliveryOption) {
            $total += $deliveryOption['price'];
        }

        return $total;
    }
}
?>
