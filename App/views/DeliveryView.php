<?php
namespace Views;

class DeliveryView {
    public function render($deliveryOptions, $errorMessage = null) {
        echo '<h2>Choisissez votre mode de livraison</h2>';
        
        if ($errorMessage) {
            echo '<div class="error">' . htmlspecialchars($errorMessage) . '</div>';
        }
        
        echo '<form method="POST" action="">';
        foreach ($deliveryOptions as $option) {
            echo '<div>';
            echo '<input type="radio" name="delivery_option_id" value="' . htmlspecialchars($option['id']) . '" required>';
            echo '<label>' . htmlspecialchars($option['name']) . ' - ' . htmlspecialchars($option['price']) . ' €</label>';
            echo '</div>';
        }
        echo '<button type="submit">Valider mon choix</button>';
        echo '</form>';
    }
}
?>
