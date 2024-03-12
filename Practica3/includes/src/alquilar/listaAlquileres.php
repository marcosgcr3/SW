<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/alquiler.php';

$contenido = '';

function elVehiculoAlquilado($row){
   $contenido = buildAlquiler($row['id_vehiculo'], $row['fechaIni'], $row['fechaFin'], $row['precio']);
   return $contenido;
}

function sinArticulos(){
    $contenido = "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
    return $contenido;
}

function añadirProducto(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addProducto.php'">Añadir producto</button>
    EOS;
    return $contenido;
}
