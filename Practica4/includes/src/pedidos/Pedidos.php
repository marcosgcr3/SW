<?php

namespace es\ucm\fdi\aw\pedidos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;
use mysqli_sql_exception;


class Pedidos 
{
    use MagicProperties;
    private $id_pedido;
    private $id_usuario;//FK  `id` int(11) NOT NULL AUTO_INCREMENT
    private $estado;//FALSE == en carrito TRUE == comprado
    private $precio_total;

    private function __construct($id_usuario, $estado, $precio_total, $id_pedido = null){
        $this->id_pedido = $id_pedido;
        $this->id_usuario = $id_usuario;
        $this->estado = $estado;
        $this->precio_total = $precio_total;
    }

    public static function crea($id_usuario, $estado, $precio_total){//crea un pedido en la base de datos
        $pedido = new Pedidos($id_usuario, $estado, $precio_total);
        return $pedido->guarda();
    }

    public static function buscarCarrito($id_usuario){//busca en la BD el unico pedido sin finalizar aka el Carrito del usuario. Solo devuelve un pedido
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT p.id_pedido, p.id_usuario, p.estado
                            FROM pedido p 
                            WHERE p.id_usuario = '%d' AND p.estado = '0'", $id_usuario);
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $pedido = new Pedidos($row['id_usuario'], $row['estado'], 0, $row['id_pedido']);
            }
            $rs->free();
        }
        else{
            //echo "No existe el carrito en la base de datos";
            $pedido = NULL;
        }
        return $pedido;
    }

    public static function listaPedidos($id_usuario){//devuelve una lista con todos los pedidos del usuario
        $lista_pedidos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT *
                            FROM pedido p 
                            WHERE p.id_usuario = '%d' AND p.estado = '1'", $id_usuario );
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $pedido = new Pedidos($row['id_usuario'], $row['estado'] , $row['precio_total'],$row['id_pedido']);
                array_push($lista_pedidos, $pedido);
            }
            $rs->free();
        }
        else{
            //echo "No hay pedidos en la base de datos";
        }
        return $lista_pedidos;
    }

    public static function borrarPedido_producto($id_pedido){//borra un pedido de la base de datos
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM pedido_producto WHERE id_pedido = '%d'", $id_pedido);
        //eliminar de pedido_producto tambien

        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}\n");
            return false;
        }
    }

    public static function borrarPedido($id_pedido){//borra un pedido de la base de datos
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM pedido WHERE id_pedido = '%d'", $id_pedido);
        //eliminar de pedido_producto tambien

        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}\n");
            return false;
        }
    }

    public function anyadirProducto($id_pedido,$id_producto, $cantidad){//añade un producto al CARRITO
        $conn = Aplicacion::getInstance()->getConexionBd();
        try{
            $query = sprintf("INSERT INTO pedido_producto (id_pedido, id_producto, cantidad) VALUES ('%d', '%d', '%d')",
            $id_pedido,
            $id_producto,
            $cantidad);
            //
            if($conn->query($query)){
                return true;
            }
            else{
                throw new mysqli_sql_exception("Error al ejecutar la consulta de inserción: " . $conn->errno . "<br>" . utf8_encode($conn->error));
            }
        }
        catch(mysqli_sql_exception $ex){
            //Manejar la excepción
            $query = sprintf("UPDATE pedido_producto SET cantidad = cantidad + '%d' WHERE id_pedido = '%d' AND id_producto = '%d'",
                $cantidad,
                $id_pedido,
                $id_producto);
            if($conn->query($query)){
                return true;
            }
            else{
                echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
                return false;
            }
        }
    }
    

    public function eliminarProducto($id_pedido,$id_producto){//elimina un producto del carrito 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM pedido_producto WHERE id_pedido = '%d' AND id_producto = '%d'",
            $id_pedido,
            $id_producto,
        );
        if($conn->query($query)){
            return true;
        }
        else{
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }

    public function eliminarProductos($id_pedido,$id_producto, $cantidad){//elimina un producto del carrito 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE pedido_producto SET cantidad = cantidad - '%d' WHERE id_pedido = '%d' AND id_producto = '%d'",
                $cantidad,
                $id_pedido,
                $id_producto
        );
        if($conn->query($query)){
            return true;
        }
        else{
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }

    public static function cantidadDeProducto($id_pedido, $id_producto){//devulve la cantidad de un producto en un pedido
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT cantidad FROM pedido_producto WHERE id_pedido = '$id_pedido' AND id_producto = '$id_producto'");
        $rs = $conn->query($query);
        if($rs -> num_rows >= 0){
            while($row = $rs->fetch_assoc()){
                $cantidad = $row['cantidad'];
            }
            $rs->free();
        }
        else{
            echo "No se pudo calcular la cantidad del producto";
        }
        return $cantidad;
    }

    public static function calculaPrecioTotal($id_pedido){//calcula el precio total del carrito
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT SUM(PR.precio * PP.cantidad) as precio_total
                           FROM pedido P
                            INNER JOIN pedido_producto PP ON P.id_pedido = PP.id_pedido
                            INNER JOIN productos PR ON PP.id_producto = PR.id_producto
                            WHERE P.id_pedido = '%d'", $id_pedido );
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $precio_total = $row['precio_total'];
            }
            $rs->free();
        }
        else{
            echo "No se pudo calcular el precio total";
        }
        return $precio_total;
    }

    public function insertaPrecioTotal($id_pedido, $precio_total){//inserta el precio total en la base de datos
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE pedido SET precio_total = '%u' WHERE id_pedido = '%d'",
            $precio_total,
            $id_pedido
        );
        if($conn->query($query)){
            return true;
        }
        else{
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }

    public function finalizarPedido($id_pedido){//cambia el estado del pedido a finalizado, hemos comprado el pedido
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE pedido SET estado = '1' WHERE id_pedido = '%d'",
            $id_pedido
        );
        if($conn->query($query)){
            return true;
        }
        else{
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }

    private static function inserta($pedido){//insertamos pedido en la base de datos 
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO pedido (id_usuario, estado, precio_total) VALUES ('%d', '%d', '%d')",
        $conn -> real_escape_string($pedido->id_usuario),
        $conn -> real_escape_string($pedido->estado),
        $conn -> real_escape_string($pedido->precio_total)); 

        if ($conn->query($query)) {
            $pedido->id_pedido = $conn->insert_id;
            $result = $pedido;
        } else {
            echo "Error al insertar en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    private static function actualiza($pedido){//actualizamos el pedido en la base de datos
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE pedido P SET id_usuario = '%d', estado = '%d', precio_total = '%d' WHERE P.id_pedido = '%d'",
            $conn->real_escape_string($pedido->id_usuario),
            $conn->real_escape_string($pedido->estado),
            $conn->$pedido->precio_total,
            $conn->id_pedido
        );
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha actualizado el pedido");
            }
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function guarda(){
        if ($this->id_pedido != null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public function getId_pedido(){
        return $this->id_pedido;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getPrecioTotal(){
        return $this->precio_total;
    }

    public function getId_usuario(){
        return $this->id_usuario;
    }
}

?>
