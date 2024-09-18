<?php

namespace AdminViews;

class AdminProductFormViews {
    public function displayForm($product, $gammes) {
        ?>
        <div class="product-form-container">
            <h1><?php echo $product['id'] ? 'Modifier le Produit' : 'Créer un Nouveau Produit'; ?></h1>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

                <label for="product_range_id">Gamme:</label>
                <select id="product_range_id" name="product_range_id" required>
                    <option value="">Choisir une gamme</option>
                    <?php foreach ($gammes as $gamme) : ?>
                        <option value="<?php echo $gamme['id']; ?>" 
                            <?php echo $product['product_range_id'] == $gamme['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($gamme['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                <br>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                <br>

                <label for="price">Prix:</label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                <br>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                <br>

                <label for="height">Hauteur (cm):</label>
                <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($product['height']); ?>">
                <br>

                <label for="weight">Poids (g):</label>
                <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($product['weight']); ?>">
                <br>

                <button type="submit" class="btn btn-primary"><?php echo $product['id'] ? 'Modifier' : 'Créer'; ?></button>
            </form>
        </div>
        <?php
    }
}
