<?php
namespace Views;

class AddressView {
    public function initForm($user, $address) {
        // Affichage du formulaire d'adresse
        echo '<form method="POST" action="">';
        echo '<input type="text" name="firstname" placeholder="Prénom" value="' . htmlspecialchars($user['firstname'] ?? '') . '" required>';
        echo '<input type="text" name="lastname" placeholder="Nom" value="' . htmlspecialchars($user['lastname'] ?? '') . '" required>';
        echo '<input type="text" name="address_1" placeholder="Adresse" value="' . htmlspecialchars($address['address_1'] ?? '') . '" required>';
        echo '<input type="text" name="address_2" placeholder="Complément d\'adresse" value="' . htmlspecialchars($address['address_2'] ?? '') . '">';
        echo '<input type="text" name="postal_code" placeholder="Code postal" value="' . htmlspecialchars($address['postal_code'] ?? '') . '" required>';
        echo '<input type="text" name="city" placeholder="Ville" value="' . htmlspecialchars($address['city'] ?? '') . '" required>';
        echo '<input type="text" name="country" placeholder="Pays" value="' . htmlspecialchars($address['country'] ?? '') . '" required>';
        echo '<button type="submit">Sauvegarder l\'adresse</button>';
        echo '</form>';
    }
}
?>
