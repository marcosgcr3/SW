<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';
require_once 'includes/src/citas/horarioMecanico.php';
require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Citas';

$contenidoPrincipal = '';
$conn = Aplicacion::getInstance()->getConexionBd();

if( $app->esCliente() ){

    $sql = "SELECT * FROM Citas WHERE id_cliente = {$_SESSION['id']}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contenidoPrincipal .= misCitas($row);
    }
    $result->free();
    } else {
        $contenidoPrincipal .= sinCitas();
    }

   
    $contenidoPrincipal .= newCita();
}else if($app->esMecanico()){
    $sql = "SELECT * FROM Citas WHERE id_mecanico = {$_SESSION['id']}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contenidoPrincipal .= misCitas($row);
        }
    $result->free();
    } else {
        $contenidoPrincipal .= "No tienes citas";
    }
   
    
    
}else if( $app->esAdmin() ){
    
}



$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
