<?php

namespace Views;

class GammesViews {
    public function displayGammes($gammes) {
        ?>
        <div class="gammes-container">
            <?php if (!empty($gammes)) : ?>
                <?php foreach ($gammes as $gamme) : ?>
                    <a href="<?php echo $gamme['name']; ?>">
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
