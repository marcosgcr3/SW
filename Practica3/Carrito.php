<?php
//En esta pagina se veran los productos que el usuario ha añadido al carrito
//se podra eliminar productos y se podra hacer el pedido, que queda registrado en los pedidos del usuario
require_once 'includes/config.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/src/Pedido/pedido.php';
require_once 'includes/design/plantillas/plantilla_tienda.php';

$tituloPagina = 'Carrito';
$contenidoPrincipal = '';	
session_start();
$usuario = Usuario::buscaUsuario($_SESSION['nombre']);
$pedidos = Pedido::buscarCarrito($usuario->id_usuario);

if($pedidos){
    $contenidoPrincipal .= '<h1>Carrito</h1>';
    $contenidoPrincipal .= '<table>';
    $contenidoPrincipal .= '<tr>';
    $contenidoPrincipal .= '<th>Nombre</th>';
    $contenidoPrincipal .= '<th>Precio</th>';
    $contenidoPrincipal .= '<th>Descripcion</th>';
    $contenidoPrincipal .= '<th>Unidades</th>';
    $contenidoPrincipal .= '<th>Imagen</th>';
    $contenidoPrincipal .= '<th>Eliminar</th>';
    $contenidoPrincipal .= '</tr>';
    foreach($pedidos as $pedido){
        $contenidoPrincipal .= '<tr>';
        $contenidoPrincipal .= '<td>'.$pedido->nombre.'</td>';
        $contenidoPrincipal .= '<td>'.$pedido->precio.'</td>';
        $contenidoPrincipal .= '<td>'.$pedido->descripcion.'</td>';
        $contenidoPrincipal .= '<td>'.$pedido->unidades.'</td>';
        $contenidoPrincipal .= '<td><img src="'.$pedido->imagen.'" width="100" height="100"></td>';
        $contenidoPrincipal .= '<td><a href="borrarProducto.php?id_producto='.$pedido->id_producto.'">Eliminar</a></td>';
        $contenidoPrincipal .= '</tr>';
    }
    $contenidoPrincipal .= '</table>';
    $contenidoPrincipal .= '<button  class="botonIni" onclick="location.href=\'procesaPedido.php\'">Hacer pedido</button>';
}else{ 
    $contenidoPrincipal .= '<h1>Carrito</h1>';
    $contenidoPrincipal .= '<p>No hay productos en el carrito</p>';
}

require_once 'includes/design/plantillas/layout.php';
?>



