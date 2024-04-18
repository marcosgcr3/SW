<?php
require_once 'includes/config.php';

$app->logout();
if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    $app->redirige('index.php');
}

$formLogout = new \es\ucm\fdi\aw\usuarios\FormularioLogout();
$formLogout->gestiona();