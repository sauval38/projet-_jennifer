<?php

namespace AdminControllers;

use AdminModels\AdminHomeModels;
use AdminViews\AdminHomeViews;

class AdminHomeControllers {
    protected $adminHomeViews;
    protected $adminHomeModels;

    public function __construct() {
        $this->adminHomeViews = new AdminHomeViews();
        $this->adminHomeModels = new AdminHomeModels(); 
    }

    public function adminImageControllers() {
        $images = $this->adminHomeModels->imagehomeModels();
        $this->adminHomeViews->homeAdminViews($images);
    }
}
