<?php

namespace AdminControllers;

use AdminViews\AdminAddColorsViews;
use AdminModels\AdminAddColorsModels;

class AdminAddColorsControllers {
    protected $adminAddColorsViews;
    protected $adminAddColorsModels;

    public function __construct() {
        $this->adminAddColorsViews = new AdminAddColorsViews();
        $this->adminAddColorsModels = new AdminAddColorsModels();
    }

    public function AddColorsControllers() {
        $this->adminAddColorsViews->addColorsViews();
    }
}