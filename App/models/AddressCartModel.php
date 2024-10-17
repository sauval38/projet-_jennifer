<?php
namespace Models;

use App\Database;

class AddressCartModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function fetchAddress() {
        $userId = $_SESSION['id'];
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT billing_address, delivery_address, city, postal_code FROM address WHERE user_id = ?");
            $pdo->execute([$userId]);
            $address = $pdo->fetch(\PDO::FETCH_ASSOC);  

            // Stocker l'adresse dans la session
            if ($address) {
                $_SESSION['user_address'] = $address;
            }

            return $address;
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération de l'adresse : " . $e->getMessage();
            return false;
        }
    }

    public function addressExists($userId) {
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM address WHERE user_id = ?");
            $pdo->execute([$userId]);
            return $pdo->fetchColumn() > 0;
        } catch (\PDOException $e) {
            echo "Erreur lors de la vérification de l'adresse : " . $e->getMessage();
            return false;
        }
    }

    public function saveAddress() {
        $userId = $_SESSION['id'];
        $billing_address = $_POST['billing_address'] ?? ''; 
        $delivery_address = $_POST['delivery_address'] ?? ''; 
        $city = $_POST['city'] ?? '';
        $postal_code = $_POST['postal_code'] ?? '';
        
        // Validation des données
        if (empty($billing_address) || empty($delivery_address) || empty($city) || empty($postal_code)) {
            echo "<h1>Veuillez remplir tous les champs obligatoires.</h1>";
            return false;
        }

        try {
            if ($this->addressExists($userId)) {
                $pdo = $this->db->getConnection()->prepare("UPDATE address SET billing_address = ?, delivery_address = ?, city = ?, postal_code = ? WHERE user_id = ?");
                $pdo->execute([$billing_address, $delivery_address, $city, $postal_code, $userId]);
                echo "<h1>Adresse mise à jour</h1>";
            } else {
                $pdo = $this->db->getConnection()->prepare("INSERT INTO address (user_id, billing_address, delivery_address, city, postal_code) VALUES (?, ?, ?, ?, ?)");
                $pdo->execute([$userId, $billing_address, $delivery_address, $city, $postal_code]);
                echo "<h1>Adresse sauvegardée</h1>";
            }

            // Mettre à jour la session avec la nouvelle adresse
            $_SESSION['user_address'] = [
                'billing_address' => $billing_address,
                'delivery_address' => $delivery_address,
                'city' => $city,
                'postal_code' => $postal_code
            ];
            return true; // Sauvegarde réussie
        } catch (\PDOException $e) {
            echo "Erreur lors de la sauvegarde de l'adresse : " . $e->getMessage();
            return false; // Erreur de sauvegarde
        }
    }
}
?>
