<?php

require_once 'controller.php';
require_once 'config.php';

$controller = new Controller($cofiguration);

if (isset($_GET['action'])) {
    $method = $_GET['action'];
    $controller->$method($_GET);
} else {
    $controller->returnIndex($_POST);
}
