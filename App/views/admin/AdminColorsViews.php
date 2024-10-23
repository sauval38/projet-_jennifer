<?php

namespace AdminViews;

class AdminColorsViews {
    public function AdminColorsViews($colors) {
        ?>
        <h1>Gestion des couleurs</h1>
        <div id="colors">
        <a href="admin/add-color" class="btn btn-primary">Créer une nouvelle couleur</a>
        <table>
            <thead>
                <tr>
                    <th>Nom de la couleur</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($colors as $color) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($color['name']); ?></td>
                        <td>
                            <!-- Utiliser un formulaire POST pour la suppression -->
                            <form method="post" action="">
                                <input type="hidden" name="color_id" value="<?php echo $color['id']; ?>">
                                <button type="submit" name="delete_color" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
        <?php
    }
}