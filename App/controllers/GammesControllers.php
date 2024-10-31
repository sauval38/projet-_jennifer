<?php

namespace Controllers;

use Models\GammesModels;
use Views\GammesViews;
use AdminViews\GammesAdminViews;
use AdminModels\AdminGammesModels;

class GammesControllers {
    protected $gammesModels;
    protected $gammesViews;
    protected $gammesAdminViews;
    protected $adminGammesModels;

    public function __construct() {
        $this->gammesModels = new GammesModels();
        $this->gammesViews = new GammesViews();
        $this->gammesAdminViews = new GammesAdminViews();
        $this->adminGammesModels = new AdminGammesModels();
    }

    public function showGammes() {
        $gammes = $this->gammesModels->getGammes();
        $this->gammesViews->displayGammes($gammes);
    }

    public function showAdminGammes() {
        $gammes = $this->adminGammesModels->getAllGammes();
        $this->gammesAdminViews->displayAdminGammes($gammes);
    }

}