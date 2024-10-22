<?php

namespace AdminViews;

class AdminAboutMeViews {
    public function displayAdminAboutMe($aboutMes) {
        ?>
        <h1>Modification de la page A propos de moi</h1>
        
        <div id="admin-about-me">
             
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            
            <form class="form" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($aboutMes['id']) ? htmlspecialchars($aboutMes['id']) : ''; ?>">

                <label for="bio">Bio:</label>
                <input type="text" id="bio" name="bio" value="<?php echo isset($aboutMes['bio']) ? htmlspecialchars($aboutMes['bio']) : ''; ?>" required>

                <label for="text_1">text 1:</label>
                <input type="text" id="text_1" name="text_1" value="<?php echo isset($aboutMes['text_1']) ? htmlspecialchars($aboutMes['text_1']) : ''; ?>" required>

                <label for="text_2">text 2:</label>
                <input type="text" id="text_2" name="text_2" value="<?php echo isset($aboutMes['text_2']) ? htmlspecialchars($aboutMes['text_2']) : ''; ?>" required>

                <label for="text_3">text 3:</label>
                <input type="text" id="text_3" name="text_3" value="<?php echo isset($aboutMes['text_3']) ? htmlspecialchars($aboutMes['text_3']) : ''; ?>" required>
                
                <?php if (!empty($aboutMes['image_path'])): ?>
                    <div class="current-image">
                        <p>Image actuelle:</p>
                        <img src="<?php echo htmlspecialchars($aboutMes['image_path']); ?>" alt="Current Image" style="max-width: 200px; max-height: 200px;">
                    </div>
                <?php endif; ?>

                <label for="image_path">Changer l'image:</label>
                <input type="file" id="image_path" name="image_path">
                
                <button type="submit" name="submit">Modifier</button>
            </form>
        </div>
        <?php
    }
}
