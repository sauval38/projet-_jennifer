<?php

namespace AdminViews;

class AdminGammeFormViews {
    public function displayForm($gamme) {
        ?>
        <div class="gamme-form-container">
            <h1><?php echo $gamme['id'] ? 'Modifier la Gamme' : 'Créer une Nouvelle Gamme'; ?></h1>
            <form action="admin/gammes/<?php echo $gamme['id'] ? 'edit/' . $gamme['id'] : 'create'; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($gamme['id']); ?>">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($gamme['name']); ?>" required>
                <br>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($gamme['description']); ?></textarea>
                <br>
                <label for="image_path">Image:</label>
                <input type="file" id="image_path" name="image_path">
                <br>
                <?php if ($gamme['image_path']) : ?>
                    <img src="<?php echo htmlspecialchars($gamme['image_path']); ?>" alt="<?php echo htmlspecialchars($gamme['name']); ?>" style="max-width: 100px;">
                <?php endif; ?>
                <br>
                <button type="submit" class="btn btn-primary"><?php echo $gamme['id'] ? 'Modifier' : 'Créer'; ?></button>
            </form>
        </div>
        <?php
    }
}
