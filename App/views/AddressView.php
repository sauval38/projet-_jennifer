<?php
namespace Views;

class AddressView {
    public function initForm($address) {
        // Affichage du formulaire d'adresse
        echo '<form method="POST" action="">';
        echo '<input type="text" name="billing_address" placeholder="Adresse de facturation" value="' . htmlspecialchars($address['billing_address'] ?? '') . '" required>';
        echo '<input type="text" name="delivery_address" placeholder="Adresse de livraison" value="' . htmlspecialchars($address['delivery_address'] ?? '') . '">';
        echo '<input type="text" name="city" placeholder="Ville" value="' . htmlspecialchars($address['city'] ?? '') . '" required>';
        echo '<input type="text" name="postal_code" placeholder="Pays" value="' . htmlspecialchars($address['postal_code'] ?? '') . '" required>';
        echo '<button type="submit">Sauvegarder l\'adresse</button>';
        echo '</form>';
    }
}
?>
