<?php

namespace Views;

class GammesViews {
    public function displayGammes($gammes) {
        ?>
        <div class="gammes-container">
            <?php if (!empty($gammes)) : ?>
                <?php foreach ($gammes as $gamme) : ?>
                    <a href="<?php echo htmlspecialchars($gamme['name']); ?>">
                        <?php echo htmlspecialchars($gamme['name']); ?>
                        <p class="description" ><?php echo htmlspecialchars($gamme['description']); ?></p>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucune gamme disponible.</p>
            <?php endif; ?>
        </div>
        <?php
    }
}


/* ajouter pour les images
<img src="<?php echo htmlspecialchars($gamme['image_path']); ?>" alt="<?php echo htmlspecialchars($gamme['name']); ?>" /> 
*/