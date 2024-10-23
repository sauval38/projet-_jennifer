<?php

namespace Views;

class CartShowView {
    public function render($cartItems) {
        ?>
        <div class="cart">
            <?php
            // Vérifie si le panier est vide
            if (empty($cartItems)) {
                ?>
                <h1>Your cart is empty.</h1> <!-- Message à afficher si le panier est vide -->
                <?php
            } else {
                foreach ($cartItems as $item) {
                    ?>
                    <div class="cart-item">
                        <img src="<?= $item['image_path']; ?>" alt="<?= $item['name']; ?>">
                        <div class="item-details">
                            <p><?= $item['name']; ?></p>
                            <p>Color: <?= $item['color']; ?></p>
                            <p>Weight: <?= $item['weight']; ?>kg</p>
                            <p>Price: €<?= $item['price']; ?></p>
                            <label for="quantity">Quantity:</label>
                            <select class="quantity-select" data-cart-detail-id="<?= $item['cart_detail_id']; ?>">
                                <?php
                                for ($i = 1; $i <= 99; $i++) {
                                    $selected = ($i == $item['quantity']) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $i; ?>" <?= $selected; ?>><?= $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button class="remove-item" data-cart-detail-id="<?= $item['cart_detail_id']; ?>">Remove</button>
                    </div>
                    <?php
                }
                ?>
                <a href="commande/adresse">COMMANDER</a>
            <?php
            }
            ?>
        </div>
        <script src="./assets/js/cartUpdate.js"></script>
        <?php
    }
}
