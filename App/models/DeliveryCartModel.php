<?php
namespace Models;

use App\Database;

class DeliveryCartModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getDeliveryOptions() {
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT id, name, price FROM delivery_option ORDER BY price ASC");
            $pdo->execute();
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des options de livraison : " . $e->getMessage();
            return [];
        }
    }

    public function saveDeliveryChoiceToSession($deliveryOptionId) {
        // Stocker l'option de livraison choisie dans la session
        $_SESSION['delivery_option_id'] = $deliveryOptionId;
    }
}
?>
