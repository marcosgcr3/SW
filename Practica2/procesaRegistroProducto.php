<?php

require_once 'includes/config.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/addProducto.php';

$tituloPagina = 'Producto añadido';

$id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_SPECIAL_CHARS);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$precio = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
$unidades = filter_input(INPUT_POST, 'unidades', FILTER_SANITIZE_SPECIAL_CHARS);
$imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_SPECIAL_CHARS);

if(Producto::buscaPorid($id_producto)){
    $htmlFormProducto = buildFormularioProducto($id_producto, $nombre, $precio, $descripcion, $unidades, $imagen);
    $contenidoPrincipal=<<<EOS
    <h1>Error</h1>
    <p>El producto ya existe.</p>
    $htmlFormProducto
EOS;
    require 'includes/design/comunes/layout.php';
    exit();
}else{
    Producto::crea($id_producto, $nombre, $precio, $descripcion, $unidades, $imagen);
    $contenidoPrincipal=<<<EOS
    <h1>Producto añadido correctamente</h1>
    EOS;
    require 'includes/design/comunes/layout.php';
    
}
