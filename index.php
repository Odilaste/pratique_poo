<?php

require_once 'Controlers/controler_login.php';

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $controller = new Controler_login();
    $controller->login();
}
else{
    include 'Views/view_login.php';
}
?>