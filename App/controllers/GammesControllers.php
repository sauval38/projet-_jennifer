<?php

namespace Controllers;

use Models\GammesModels;
use Views\GammesViews;
use AdminViews\GammesAdminViews;

class GammesControllers {
    protected $gammesModels;
    protected $gammesViews;
    protected $gammesAdminViews;

    public function __construct() {
        $this->gammesModels = new GammesModels();
        $this->gammesViews = new GammesViews();
        $this->gammesAdminViews = new GammesAdminViews();
    }

    public function showGammes() {
        $gammes = $this->gammesModels->getGammes();
        $this->gammesViews->displayGammes($gammes);
    }

    public function showAdminGammes() {
        $gammes = $this->gammesModels->getGammes();
        $this->gammesAdminViews->displayAdminGammes($gammes);
    }

}