<?php

namespace AdminViews;

class GammesAdminViews {
    public function displayAdminGammes($gammes) {
        ?>
        <div id="admin-gammes-container">
            <h1>Gestion des Gammes</h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            <a href="admin/gammes/create" class="btn btn-primary">Créer une nouvelle gamme</a>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($gammes)) : ?>
                        <?php foreach ($gammes as $gamme) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($gamme['name']); ?></td>
                                <td><?php echo htmlspecialchars($gamme['description']); ?></td>
                                <td>
                                    <?php if (!empty($gamme['image_path'])) : ?>
                                        <img src="<?php echo htmlspecialchars($gamme['image_path']); ?>" alt="<?php echo htmlspecialchars($gamme['name']); ?>" style="max-width: 100px;">
                                    <?php else : ?>
                                        Pas d'image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="admin/gammes/edit/<?php echo $gamme['id']; ?>" class="btn btn-secondary">Modifier</a>
                                    <a href="admin/gammes/delete/<?php echo $gamme['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette gamme ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4">Aucune gamme disponible.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
