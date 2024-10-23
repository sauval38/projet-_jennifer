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
            $pdo = $this->db->getConnection()->prepare("SELECT address_1, address_2, postal_code, city, country FROM delivery_address WHERE user_id = ?");
            $pdo->execute([$userId]);
            $address = $pdo->fetch(\PDO::FETCH_ASSOC);

            // Stocker l'adresse dans la session
            if ($address) {
                $_SESSION['delivery_address'] = $address;
            }

            return $address;
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération de l'adresse : " . $e->getMessage();
            return false;
        }
    }

    public function fetchName() {
        $userId = $_SESSION['id'];
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
            $pdo->execute([$userId]);
            $names = $pdo->fetch(\PDO::FETCH_ASSOC);

            return $names;
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des noms : " . $e->getMessage();
            return false;
        }
    }

    public function addressExists($userId) {
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM delivery_address WHERE user_id = ?");
            $pdo->execute([$userId]);
            return $pdo->fetchColumn() > 0;
        } catch (\PDOException $e) {
            echo "Erreur lors de la vérification de l'adresse : " . $e->getMessage();
            return false;
        }
    }

    public function saveAddress() {
        $userId = $_SESSION['id'];
        $firstname = $_POST['firstname'] ?? ''; 
        $lastname = $_POST['lastname'] ?? ''; 
        $addressOne = $_POST['address_1'] ?? ''; 
        $addressTwo = $_POST['address_2'] ?? ''; 
        $postal_code = $_POST['postal_code'] ?? '';
        $city = $_POST['city'] ?? '';
        $country = $_POST['country'] ?? '';
        
        // Validation des données
        if (empty($firstname) || empty($lastname) || empty($addressOne) || empty($postal_code) || empty($city) || empty($country)) {
            echo "<h1>Veuillez remplir tous les champs obligatoires.</h1>";
            return false;
        }

        try {
            if ($this->addressExists($userId)) {
                $pdo = $this->db->getConnection()->prepare("UPDATE delivery_address SET address_1 = ?, address_2 = ?, postal_code = ?, city = ?, country = ? WHERE user_id = ?");
                $pdo->execute([$addressOne, $addressTwo, $postal_code, $city, $country, $userId]);
                
                $pdo = $this->db->getConnection()->prepare("UPDATE users SET firstname = ?, lastname = ? WHERE id = ?");
                $pdo->execute([$firstname, $lastname, $userId]);
                echo "<h1>Adresse mise à jour</h1>";
            } else {
                $pdo = $this->db->getConnection()->prepare("INSERT INTO delivery_address (user_id, address_1, address_2, postal_code, city, country) VALUES (?, ?, ?, ?, ?, ?)");
                $pdo->execute([$userId, $addressOne, $addressTwo, $postal_code, $city, $country]);

                $pdo = $this->db->getConnection()->prepare("UPDATE users SET firstname = ?, lastname = ? WHERE id = ?");
                $pdo->execute([$firstname, $lastname, $userId]);
                echo "<h1>Adresse sauvegardée</h1>";
            }

            // Mettre à jour la session avec la nouvelle adresse
            $_SESSION['delivery_address'] = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'address_1' => $addressOne,
                'address_2' => $addressTwo,
                'postal_code' => $postal_code,
                'city' => $city,
                'country' => $country
            ];
            return true; // Sauvegarde réussie
        } catch (\PDOException $e) {
            echo "Erreur lors de la sauvegarde de l'adresse : " . $e->getMessage();
            return false; // Erreur de sauvegarde
        }
    }
}
?>
