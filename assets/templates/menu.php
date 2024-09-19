<nav id="menu">
    <a class="logo-site" href=""><img src="<?= IMG;?>LOGO-COMPLET-TRANSPARENT-Rose.gif" alt=""></a>
    
    <div class="menu-items">
        <div>
            <?php
            
            if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false && isset($_SESSION['is_logged_in']) && $_SESSION['role'] === "ADMIN"):
            ?>
                <!-- Admin Navigation -->
                <a href="./">Retour au Site</a>
                <a href="admin">Tableau de bord</a>
                <a href="admin/settings">Options</a>
            <?php else: ?>
                <!-- Regular Navigation -->
                <a href="">Accueil</a>
                <a href="gammes">Gamme</a>
                <a href="">A propos de moi</a>
            <?php endif; ?>
        </div>

        <div>
            <?php if (isset($_SESSION['is_logged_in'])): ?>
                <a href="profile">Bonjour, <?= ($_SESSION['username']); ?></a>
                <a href="logout">Déconnexion</a>
            <?php else: ?>
                <a href="login">Se connecter</a>
            <?php endif; ?>
            <a class="cart-icon" href=""><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>
</nav>
<div id="body-content">



