<?php

namespace AdminViews;

class AdminAboutMeViews {
    public function displayAdminAboutMe($aboutMes) {
        ?>

        <div id="admin-about-me">
            <h1>Modification de la page A propos de moi</h1> 
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
