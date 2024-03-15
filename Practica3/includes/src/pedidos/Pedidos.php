<?php

namespace es\ucm\fdi\aw\pedidos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;
class Pedidos 
{
    use MagicProperties;
    private $id_pedido;
    private $id_usuario;//FK  `id` int(11) NOT NULL AUTO_INCREMENT
    private $estado;//FALSE == en carrito TRUE == comprado
    private $precio_total;

    private function __construct($id_pedido, $id_usuario, $estado, $precio_total, $producto){
        $this->id_pedido = $id_pedido;
        $this->id_usuario = $id_usuario;
        $this->estado = $estado;
        $this->precio_total = $precio_total;
    }

    public static function crea($id_usuario, $estado, $precio_total){//crea un pedido en la base de datos
        $pedido = new Pedidos(null, $id_usuario, $estado, $precio_total);
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
                $pedido = new Pedidos($row['id_pedido'], $row['id_usuario'], $row['estado'], 0);
            }
            $rs->free();
        }
        else{
            echo "No existe el carrito en la base de datos";
            $pedido = NULL;
        }
        return $pedido;
    }	

    public static function listaPedidos($id_usuario){//devuelve una lista con todos los pedidos del usuario
        $lista_pedidos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT p.id_pedido, p.id_usuario, p.estado
                            FROM pedido p 
                            WHERE P.id_usuario = '%d'", $id_usuario );
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $pedido = new Pedidos($row['id_pedido'], $row['id_usuario'], $row['estado'], $row['precio_total']);
                array_push($lista_pedidos, $pedido);
            }
            $rs->free();
        }
        else{
            echo "No hay pedidos en la base de datos";
        }
        return $lista_pedidos;
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
        $query = sprintf("INSERT INTO pedido_producto (id_pedido, id_producto, cantidad) VALUES ('%d', '%d', '%d')",
            $id_pedido,
            $id_producto,
            $cantidad
        );
       if($conn->query($query)){
            return true;
        }
        else{
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }
    

    public function eliminarProducto($id_pedido,$id_producto){//elimina un producto del carrito y devuelve la cantidad al producto a la BD 
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

    public function calculaPrecioTotal($id_pedido){//calcula el precio total del carrito
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

    private static function inserta($pedido){//insertamos pedido en la base de datos 
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO pedido (id_usuario, estado, precio_total) 
        VALUES ('$pedido->id_usuario', '$pedido->estado', '$pedido->precio_total')");
        if ($conn->query($query)) {
            $pedido->id_pedido = $pedido->id_usuario + 1;
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
            $pedido->real_escape_string($pedido->id_usuario),
            $pedido->real_escape_string($pedido->estado),
            $pedido->$pedido->precio_total,
            $pedido->id_pedido
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

    public function guarda(){//guarda el pedido en la base de datos
        if ($this->id_pedido != null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public function getEstado(){
        return $this->estado;
    }
    
    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getPrecioTotal(){
        return $this->precio_total;
    }

    public function setPrecioTotal($precio_total){
        $this->precio_total = $precio_total;
    }

    public function getId_pedido(){
        return $this->id_pedido;
    }

    public function getId_usuario(){
        return $this->id_usuario;
    }
}

?>