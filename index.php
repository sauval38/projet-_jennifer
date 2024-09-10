<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

const CONT = 'App/controllers/';
const MOD = 'App/models/';
const View = 'App/views/';
const JS =  'assets/js/';
const CSS = 'assets/css/';
const IMG = 'assets/images/';
const TMP = 'assets/templates/';

require_once TMP . 'top.php';
require_once TMP . 'menu.php';
require_once 'router.php';
require_once TMP . 'bottom.php';