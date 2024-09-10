<?php

namespace AdminControllers;

use AdminViews\AdminDashboardViews;

class AdminDashboardControllers {
    protected $adminDashboardViews;

    public function __construct() {
        $this->adminDashboardViews = new AdminDashboardViews();
    }

    public function showAdminBoard() {
        $this->adminDashboardViews->displayAdminBoard();
    }
}