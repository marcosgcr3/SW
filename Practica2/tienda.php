<?php

require_once 'includes/config.php';
require_once 'includes/design/plantillas/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/src/listado_tienda.php';
$tituloPagina = 'Tienda';

$contenidoPrincipal = '';
$conn = BD::getInstance()->getConexionBd();
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

if( esAdmin() ){
    $contenidoPrincipal.= añadirProducto();
}
require 'includes/design/comunes/layout.php';
