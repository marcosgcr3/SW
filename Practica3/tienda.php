<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/productos/listado_tienda.php';

require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Tienda';

$contenidoPrincipal = '';
$conn = Aplicacion::getInstance()->getConexionBd();
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contenidoPrincipal .= elArticulo($row);
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
