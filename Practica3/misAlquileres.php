<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/alquilar/listaAlquileres.php';

require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Tienda';

$contenidoPrincipal = '';
$conn = Aplicacion::getInstance()->getConexionBd();
$sql = "SELECT * FROM alquileres WHERE id_usuario = {$_SESSION['id']}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contenidoPrincipal .= elVehiculoAlquilado($row);
    }
    $result->free();
} else {
    $contenidoPrincipal .= sinArticulos();
}

if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirProducto();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
