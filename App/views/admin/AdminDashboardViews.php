<?php

namespace AdminViews;

class AdminDashboardViews {
    public function displayAdminBoard() {
        ?>
        <h1>BIENVENUE, CHÈRE ADMIN</h1>
        <section id="admin-board">
            <a href="">GAMMES</a>
            <a href="">PRODUITS</a>
            <a href="">COULEURS</a>
            <a href="">A PROPOS DE MOI</a>
            <a href="">RESEAUX SOCIAUX</a>
            <a href="">UTILISATEURS</a>
        </section>
        <?php 
    }
}