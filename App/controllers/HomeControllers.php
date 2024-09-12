<?php

namespace Controllers;

use Views\HomeViews;

class HomeControllers {
    protected $homeViews;

    public function __construct() {
        $this->homeViews = new HomeViews();   
    }

    public function home() {
        $this->homeViews->body();
    }
}
