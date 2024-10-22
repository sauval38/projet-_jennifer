<?php

namespace AdminViews;

class AdminHomeFormViews {
    public function homeFormAdminViews($image) {
        ?>
        <h1>Modifier l'image</h1>
        <div id="image_modification">
        <form class="form" action="admin/home/modification" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
            <label>Image actuelle :</label>
            <img src="<?php echo $image['image_path']; ?>" alt="Image" width="150">
            
            <label for="new_image">Nouvelle image :</label>
            <input type="file" name="image" id="new_image" required> 
            <button type="submit">Modifier</button>
        </form>

        </div>
        <?php
    }
}
