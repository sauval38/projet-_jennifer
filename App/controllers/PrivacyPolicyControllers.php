<?php

namespace Controllers;

use Views\PrivacyPolicyViews;

class PrivacyPolicyControllers {
    protected $privacyPolicyViews;

    public function __construct() {
        $this->privacyPolicyViews = new PrivacyPolicyViews();
    }

    public function privacyPolicyController() {
        $this->privacyPolicyViews->privacyPolicyViews();
    }
}