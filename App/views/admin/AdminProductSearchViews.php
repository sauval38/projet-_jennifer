<?php

namespace AdminViews;

class AdminProductSearchViews {
    public function displayProductList($products, $gammes, $selectedRangeId) {
        ?>
        <div id="product-search-container">
            <h1>Liste des Produits</h1>
            
            <!-- Formulaire de filtrage -->
            <form method="get" action="">
                <label for="product_range_id">Filtrer par gamme :</label>
                <select id="product_range_id" name="product_range_id" onchange="this.form.submit()">
                    <option value="">Toutes les gammes</option>
                    <?php foreach ($gammes as $gamme) : ?>
                        <option value="<?php echo $gamme['id']; ?>"
                            <?php echo $selectedRangeId == $gamme['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($gamme['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            <a href="admin/products/create" class="btn btn-primary">Créer un nouveau produit</a>

            <!-- Liste des produits -->
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Hauteur</th>
                        <th>Poids</th>
                        <th>Gamme</th>
                        <th>Archivé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['description']); ?></td>
                                <td><?php echo htmlspecialchars($product['price']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td><?php echo htmlspecialchars($product['height']); ?></td>
                                <td><?php echo htmlspecialchars($product['weight']); ?></td>
                                <td><?php echo htmlspecialchars($product['gamme_name']); ?></td>
                                <td><?php echo $product['archived'] == 1 ? 'oui' : 'non'; ?></td>
                                <td>
                                    <a href="admin/products/edit/<?php echo $product['id']; ?>" class="btn btn-secondary">Modifier</a>
                                    <a href="admin/products/delete/<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir archiver ce produit ?');">Archiver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">Aucun produit trouvé pour cette gamme.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
