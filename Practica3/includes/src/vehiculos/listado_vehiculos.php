<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/vehiculo.php';

$contenido = '';

function elVehiculo($row){
   $contenido = buildVehiculo( $row['matricula'],$row['marca'], $row['modelo'], $row['precio'], $row['year'],$row['imagen']);
   return $contenido;
}

function sinVehiculo(){
    $contenido = "<tr><td colspan='4'>No hay vehiculos disponibles</td></tr>";
    return $contenido;
}

function añadirVehiculo(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addVehiculo.php'">Añadir Vehiculo</button>
    EOS;
    return $contenido;
}
