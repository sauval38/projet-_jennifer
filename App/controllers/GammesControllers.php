<?php

namespace Controllers;

use Models\GammesModels;
use Views\GammesViews;

class GammesControllers {
    protected $gammesModels;
    protected $gammesViews;

    public function __construct() {
        $this->gammesModels = new GammesModels();
        $this->gammesViews = new GammesViews();
    }

    public function showGammes() {
        $gammes = $this->gammesModels->getGammes();
        $this->gammesViews->displayGammes($gammes);
    }

}