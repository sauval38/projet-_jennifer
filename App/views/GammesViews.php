<?php

namespace Views;

class GammesViews {
    public function displayGammes($gammes) {
        ?>
        <h1>Ici, ma liste des gammes de mon univers</h1>
        <div class="gammes-container">
            <?php if (!empty($gammes)) : ?>
                <?php foreach ($gammes as $gamme) : ?>
                    <a href="<?php echo htmlspecialchars($gamme['name']); ?>">
                        <div class="gamme-item">
                            <figure>
                                <img src="<?php echo htmlspecialchars($gamme['image_path']); ?>" alt="<?php echo htmlspecialchars($gamme['name']); ?>" />
                                <figcaption>
                                    <h4><?php echo htmlspecialchars($gamme['name']); ?></h4>
                                </figcaption>
                            </figure>
                            <p class="description"><?php echo htmlspecialchars($gamme['description']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucune gamme disponible.</p>
            <?php endif; ?>
        </div>
        <?php
    }
}
