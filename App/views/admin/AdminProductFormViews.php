<?php

namespace AdminViews;

class AdminProductFormViews {
    public function displayForm($product, $gammes, $images = []) {
        ?>
        <div class="product-form-container">
            <h1><?php echo $product['id'] ? 'Modifier le Produit' : 'Créer un Nouveau Produit'; ?></h1>
            <form action="" method="post" enctype="multipart/form-data">
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

                <!-- Ajout de l'upload multiple d'images -->
                <label for="images">Images:</label>
                <input type="file" id="images" name="images[]" multiple>
                <br>

                <!-- Affichage des images actuelles (s'il y en a) -->
                <?php if (!empty($images)) : ?>
                    <div class="current-images">
                        <h3>Images actuelles:</h3>
                        <?php foreach ($images as $image) : ?>
                            <div class="image-item" style="display:inline-block; margin-right:10px;">
                                <img src="<?php echo $image['image_path']; ?>" alt="Image du produit" style="width:100px; height:100px;">
                                <a href="admin/products/deleteImage/<?php echo $image['id']; ?>/product/<?php echo $product['id']; ?>" class="delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');">X</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <br>

                <button type="submit" class="btn btn-primary"><?php echo $product['id'] ? 'Modifier' : 'Créer'; ?></button>
            </form>
        </div>
        <?php
    }
}
