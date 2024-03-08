<?php

class Pedidos extends Usuario
{
    use MagicProperties;

    private $estado;//FALSE == en carrito TRUE == comprado
    private $id_pedido;
    private $id_usuario;
    private $lista_productos = array();   //Temporal

    private function __construct($estado, $id_pedido, $id_usuario, $lista_productos){
        $this->estado = $estado;
        $this->id_pedido = $id_pedido;
        $this->id_usuario = $id_usuario;
        $this->lista_productos = $lista_productos;
    }

    public static function buscarCarrito($id_usuario){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM pedidos WHERE id_usuario = '%d' AND estado = '0'", $id_usuario);
        $rs = $conn->query($query);
        $pedidos = [];
        while ($fila = $rs->fetch_assoc()) {
            $pedido = new Pedido($fila['estado'], $fila['id_pedido'], $fila['id_usuario'], $fila['lista_productos']);
            array_push($pedidos, $pedido);
        }
        return $pedidos;
    }	

    public static function listaPedidos($id_usuario){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.id_pedido, P.estado, PP.id_producto, PR.nombre, PR.precio, PR.descripcion, PR.unidades, PR.imagen 
                            FROM pedidos P 
                            JOIN pedido_producto PP ON P.id_pedido = PP.id_pedido 
                            JOIN productos PR ON PP.id_producto = PR.id_producto
                            WHERE P.id_usuario = '%d'", $id_usuario );
        $rs = $conn->query($query);
        $pedidos = [];
        while ($fila = $rs->fetch_assoc()) {
            $pedido = new Pedido($fila['estado'], $fila['id_pedido'], $fila['id_usuario'], $fila['lista_productos']);
            array_push($pedidos, $pedido);
        }
        return $pedidos;
    }

    public static function borrarPedido($id_pedido){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Pedidos WHERE id_pedido = '%d'", $id_pedido);
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function anyadirProducto($producto){
        array_push($lista, $producto->nombre);
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE productos P SET unidades = '%d' WHERE P.id_producto = '%d' " ,
            $producto->unidades-$cantidad,
            $producto->id_producto
        );
        $query2 = sprintf("INSERT INTO pedido_producto (id_pedido, id_producto, cantidad) VALUES ('%d', '%d', '%d')",
            $this->id_pedido,
            $producto->id_producto,
            $cantidad
        );
        $query3 = sprintf("UPDATE pedidos P SET estado = '%d' WHERE P.id_pedido = '%d' " ,
            $this->estado,
            $this->id_pedido
        );
    }
    

    public function eliminarProducto($producto){
        if(in_array($producto->nombre, $lista)){
            unset($lista[1]);   //solo funciona en arrays asociativos
            $result = false;
            $conn = BD::getInstance()->getConexionBd();
            $query = sprintf("UPDATE Productos P SET unidades = '%d' WHERE P.id_producto = '%d' " ,
                $producto->unidades+$cantidad,
                $producto->id_producto
            );
            $query2 = sprintf("DELETE FROM pedido_producto WHERE id_pedido = '%d' AND id_producto = '%d'",
                $this->id_pedido,
                $producto->id_producto
            );	
        }
    }

    public static function guarda($pedido){
        if ($pedido->id_pedido !== null) {
            return self::actualiza($pedido);
        }
        return self::inserta($pedido);
    }

    private static function inserta($pedido){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO pedidos (estado, id_usuario) VALUES ('%d', '%d')",
            $pedido->estado,
            $pedido->id_usuario
        );
        if ($conn->query($query) === TRUE) {
            $pedido->id_pedido = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: " . $conn->errono . "<br>" . utf8_encode($conn->error);
            exit();
        }
        return $pedido;
    }

    private static function actualiza($id_pedido){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        return $result;
    }

    public function getEstado(){
        return $this->estado;
    }
    
    public function setEstado($estado){
        $this->estado = $estado;
    }
}

?>