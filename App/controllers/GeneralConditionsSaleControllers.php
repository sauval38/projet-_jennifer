<?php

namespace Controllers;

use Views\GeneralConditionsSaleViews;

class GeneralConditionsSaleControllers {
    protected $generalConditionsSaleViews;

    public function __construct() {
        $this->generalConditionsSaleViews = new GeneralConditionsSaleViews();
    }

    public function generalConditionController() {
        $this->generalConditionsSaleViews->generalConditionViews();
    }
}