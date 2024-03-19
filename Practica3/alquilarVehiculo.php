<?php

require_once __DIR__.'/includes/config.php';
if($app->usuarioLogueado()){
    
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);

    $formAlquiler = new \es\ucm\fdi\aw\alquilar\FormularioAlquiler($matricula);
    $formAlquiler = $formAlquiler->gestiona();


    $tituloPagina = 'Alquiler de vehiculo';
    $contenidoPrincipal=<<<EOF
        <h1>Alquilando</h1>
        $formAlquiler
    EOF;




}
else{
    header('Location: noUsuarioAviso.php');
}
   


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);