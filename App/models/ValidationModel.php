<?php
namespace Models; // Définition du namespace pour la classe ValidationModel

use App\Database; // Importation de la classe Database depuis l'espace de noms App

class ValidationModel { // Définition de la classe ValidationModel

    protected $db; // Déclaration d'une propriété protégée pour stocker l'objet de connexion à la base de données

    public function __construct() { // Constructeur de la classe ValidationModel
        $this->db = new Database(); // Initialise la connexion à la base de données
    }

    public function prepareOrder() { // Méthode pour préparer une commande
        $cartId = $_SESSION['cart_id']; // Récupération de l'identifiant du panier depuis la session
        $pdo = $this->db->getConnection()->prepare('SELECT * FROM user_cart WHERE id = ?'); // Préparation de la requête SQL pour récupérer les détails du panier
        $pdo->execute([$cartId]); // Exécution de la requête SQL avec l'identifiant du panier comme paramètre
        $pko = $pdo->fetch(\PDO::FETCH_ASSOC); // Récupération des détails du panier

        $userId = $_SESSION['id']; // Récupération de l'identifiant de l'utilisateur depuis la session
        $orderDate = date("Y-m-d H:i:s"); // Récupération de la date et de l'heure actuelles au format MySQL
        $orderStatus = 0; // Initialisation du statut de la commande à 0 (non traitée)
        $amountExcVat = $pko['amount_exc_vat']; // Récupération du montant hors TVA du panier
        $paymentId = $_SESSION['selected_payment']; // Récupération de l'identifiant du mode de paiement sélectionné depuis la session
        $deliveryId = $_SESSION['selected_delivery_option']; // Récupération de l'identifiant de l'option de livraison sélectionnée depuis la session

        try { // Tentative d'exécution des instructions suivantes
            $pdo = $this->db->getConnection()->prepare("INSERT INTO user_order (user_id, order_date, amount_exc_vat, order_status, payment_id, delivery_id) VALUES (?, ?, ?, ?, ?, ?)"); // Préparation de la requête SQL pour insérer une nouvelle commande dans la base de données
            $pdo->execute([$userId, $orderDate, $amountExcVat, $orderStatus, $paymentId, $deliveryId]); // Exécution de la requête SQL avec les valeurs des champs
            $orderId = $this->db->getConnection()->lastInsertId(); // Récupération de l'identifiant de la dernière commande insérée

            $pdo = $this->db->getConnection()->prepare('SELECT * FROM user_cart_detail WHERE cart_id = ?'); // Préparation de la requête SQL pour récupérer les détails des produits dans le panier
            $pdo->execute([$cartId]); // Exécution de la requête SQL avec l'identifiant du panier comme paramètre
            
            // Boucle sur tous les produits dans le panier
            while($order = $pdo->fetch(\PDO::FETCH_ASSOC)) { // Tant qu'il y a des produits à récupérer
                $productId = $order['product_id']; // Récupération de l'identifiant du produit
                $priceExcVat = $order['price_exc_vat']; // Récupération du prix hors TVA du produit
                $qte = $order['quantity']; // Récupération de la quantité du produit
                $vat = $order['vat']; // Récupération du taux de TVA du produit
                $vatAmount = $order['vat_amount']; // Récupération du montant de TVA du produit
                
                // Préparation de la requête SQL pour insérer les détails du produit dans la commande
                $ins = $this->db->getConnection()->prepare('INSERT INTO user_order_detail SET order_id = ?, product_id = ?, product_option_id = 0, product_option_value = 0, price_exc_vat = ?, quantity = ?, vat = ?, vat_amount = ?');
                
                // Exécution de la requête SQL avec les valeurs des champs
                $ins->execute([$orderId, $productId, $priceExcVat, $qte, $vat, $vatAmount]);
            }

            // Marque le succès si toutes les opérations ont réussi
            $success = true;

            // Si succès, supprime le panier
            if ($success) {
                $pdo = $this->db->getConnection()->prepare('DELETE user_cart_detail.* FROM user_cart_detail WHERE cart_id = ?'); // Préparation de la requête SQL pour supprimer les détails du panier
                $pdo->execute([$cartId]); // Exécution de la requête SQL avec l'identifiant du panier comme paramètre

                $pdo = $this->db->getConnection()->prepare('DELETE user_cart.* FROM user_cart WHERE id = ?'); // Préparation de la requête SQL pour supprimer le panier lui-même
                $pdo->execute([$cartId]); // Exécution de la requête SQL avec l'identifiant du panier comme paramètre
            }

            echo "<h1>Commande passée avec succès</h1>"; // Affichage du message de succès
        } catch (\PDOException $e) { // Capture de toute exception PDO
            echo "Erreur lors de la création de la commande : " . $e->getMessage(); // Affichage du message d'erreur
        }
    }
}