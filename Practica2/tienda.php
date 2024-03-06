<?php

require_once 'includes/config.php';
require_once 'includes/design/plantillas/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/src/Producto/producto.php';
$tituloPagina = 'Tienda';




$conn = BD::getInstance()->getConexionBd();
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);


$contenidoPrincipal = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contenidoPrincipal .= buildArticulo($row['nombre'], $row['precio'], $row['descripcion'], $row['unidades'], $row['imagen']);
        
    
    }
    $result->free();
} else {
    $contenidoPrincipal .= "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
}

if( esAdmin() ){
    $contenidoPrincipal.=<<<EOS
    
    <button class="botonIni" onclick="location.href='addProducto.php'">Añadir producto</button>
    EOS;
   
    


}
require 'includes/design/comunes/layout.php';




