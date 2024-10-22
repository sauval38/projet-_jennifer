<?php

namespace AdminControllers;

use adminViews\AdminFormAboutMeViews;

class AdminFormAboutMeControllers {
    protected $adminFormAboutMeViews;

    public function __construct() {
        $this->adminFormAboutMeViews = new AdminFormAboutMeViews();
    }

    public function showFormAboutMe() {
        $this->adminFormAboutMeViews->displayForm();
    }
}