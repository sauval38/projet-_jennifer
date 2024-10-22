<?php

namespace AdminViews;

class AdminHomeViews {
    
    public function homeAdminViews($images) {
        ?>
        <h1>Gestion des images de l'accueil</h1>
        <div id="image_home">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Information</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($images as $image): ?>
                    <tr>
                        <td><img src="<?php echo $image['image_path']; ?>" alt="Image" width="100"></td>
                        <td><?php echo $image['informations']; ?></td> 
                        <td>
                            <form action="admin/home/modification" method="POST">
                                <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                                <button type="submit">Modifier</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
