<?php
namespace Views;

class RecapOrderView {
    public function render($cartDetails, $deliveryOption, $totalAmount) {
        echo '<h2>Récapitulatif de votre commande</h2>';
        
        echo '<h3>Détails du panier :</h3>';
        echo '<ul>';
        foreach ($cartDetails as $item) {
            echo '<li>';
            echo 'Produit : ' . htmlspecialchars($item['name']) . '<br>';
            echo 'Quantité : ' . htmlspecialchars($item['quantity']) . '<br>';
            echo 'Prix unitaire : ' . htmlspecialchars($item['price']) . ' €<br>';
            echo 'Total : ' . htmlspecialchars($item['price'] * $item['quantity']) . ' €<br>';
            if ($item['color']) {
                echo 'Couleur : ' . htmlspecialchars($item['color']) . '<br>';
            }
            if ($item['image_path']) {
                echo '<img src="' . htmlspecialchars($item['image_path']) . '" alt="Image du produit" width="100">';
            }
            echo '</li>';
        }
        echo '</ul>';
        
        if ($deliveryOption) {
            echo '<h3>Livraison :</h3>';
            echo 'Mode : ' . htmlspecialchars($deliveryOption['name']) . '<br>';
            echo 'Prix : ' . htmlspecialchars($deliveryOption['price']) . ' €<br>';
        }

        echo '<h3>Total à payer :</h3>';
        echo '<strong>' . htmlspecialchars($totalAmount) . ' €</strong>';

        echo '<form method="GET" action="commande/paiement">';
        echo '<button type="submit">Passer au paiement</button>';
        echo '</form>';
    }
}
?>
