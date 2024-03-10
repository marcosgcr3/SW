<?php

class Pedidos 
{
    use MagicProperties;

    private $id_pedido;
    private $id_usuario;//FK  `id` int(11) NOT NULL AUTO_INCREMENT
    private $estado;//FALSE == en carrito TRUE == comprado
    private $precio_total;

    private $lista_productos = array();

    private function __construct($id_pedido, $id_usuario, $estado, $precio_total, $producto){
        $this->id_pedido = $id_pedido;
        $this->id_usuario = $id_usuario;
        $this->estado = $estado;
        $this->precio_total = $precio_total;
       array_push($this->lista_productos, $producto);
    }

    public static function crea($id_usuario, $estado, $precio_total){//crea un pedido en la base de datos
        $pedido = new Pedidos(null, $id_usuario, $estado, $precio_total, null);
        return $pedido->guarda();
    }

    public static function buscarCarrito($id_usuario){//busca en la BD el unico pedido sin finalizar aka el Carrito del usuario. Solo devuelve un pedido
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT id_pedido, producto.nombre, pp.cantidad, producto.precio, producto.imagen 
                            FROM pedido p 
                            JOIN pedido_producto pp ON p.id_pedido = pp.id_pedido 
                            JOIN productos producto ON pp.id_producto = producto.id_producto 
                            WHERE p.id_usuario = '%d' AND p.estado = '0'", $id_usuario);
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $producto = new Producto($row['id_producto'], $row['nombre'], $row['precio'], $row['descripcion'], $row['unidades'], $row['imagen']);
                $pedido = new Pedidos($row['id_pedido'], $row['id_usuario'], $row['estado'], $row['precio_total'], $producto);
            }
            $rs->free();
        }
        else{
            echo "No hay productos en el carrito";
        }
        return $pedido;
    }	

    public static function listaPedidos($id_usuario){//devuelve una lista con todos los pedidos del usuario
        $lista_pedidos = array();
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.id_pedido, P.estado, PP.id_producto, PR.nombre, PR.precio, PR.descripcion, PR.unidades, PR.imagen 
                            FROM pedido P 
                            JOIN pedido_producto PP ON P.id_pedido = PP.id_pedido 
                            JOIN productos PR ON PP.id_producto = PR.id_producto
                            WHERE P.id_usuario = '%d'", $id_usuario );
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $producto = new Producto($row['id_producto'], $row['nombre'], $row['precio'], $row['descripcion'], $row['unidades'], $row['imagen']);
                $pedido = new Pedidos($row['id_pedido'], $row['id_usuario'], $row['estado'], $row['precio_total'], $producto);
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
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM pedido WHERE id_pedido = '%d'", $id_pedido);
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            file_put_contents("falloBD.txt",$query);
            error_log("Error BD ({$conn->errno}): {$conn->error}\n");
            return false;
        }
    }

    public function anyadirProducto($producto, $cantidad, $carrito){//añade un producto al CARRITO. ademas baja la cantidad de unidades del producto en la BD. actualiza el carrito
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE productos P SET unidades = '%d' WHERE P.id_producto = '%d' " ,
            $producto->unidades-$cantidad,
            $producto->id_producto
        );
        $query2 = sprintf("INSERT INTO pedido_producto (id_pedido, id_producto, cantidad) VALUES ('%d', '%d', '%d')",
            $carrito->id_pedido,
            $producto->id_producto,
            $cantidad
        );
        $query3 = sprintf("UPDATE pedido P SET precio_total = '%d' WHERE P.id_pedido = '%d' " ,
            $carrito->precio_total+$producto->precio*$cantidad,
            $carrito->id_pedido
        );
        if($conn->query($query) === TRUE && $conn->query($query2) === TRUE && $conn->query($query3) === TRUE){
            return true;
        }
        else{
            file_put_contents("falloBD.txt",$query);
            file_put_contents("falloBD.txt",$query2);
            file_put_contents("falloBD.txt",$query3);
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }
    

    public function eliminarProducto($producto, $cantidad, $carrito){//elimina un producto del carrito y devuelve la cantidad al producto a la BD 
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE productos P SET unidades = '%d' WHERE P.id_producto = '%d' " ,
            $producto->unidades+$cantidad,
            $producto->id_producto
        );
        $query2 = sprintf("DELETE FROM pedido_producto WHERE id_pedido = '%d' AND id_producto = '%d'",
            $carrito->id_pedido,
            $producto->id_producto
        );
        $query3 = sprintf("UPDATE pedido P SET precio_total = '%d' WHERE P.id_pedido = '%d' " ,
            $carrito->precio_total-$producto->precio*$cantidad,
            $carrito->id_pedido
        );
        if($conn->query($query) === TRUE && $conn->query($query2) === TRUE && $conn->query($query3) === TRUE){
            return true;
        }
        else{
            file_put_contents("falloBD.txt",$query);
            file_put_contents("falloBD.txt",$query2);
            file_put_contents("falloBD.txt",$query3);
            echo "Error en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            return false;
        }
    }

    private static function inserta($pedido){//insertamos pedido en la base de datos 
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO pedido (id_usuario, estado, precio_total) VALUES ('%d', '%d', '%d')",
            $pedido->id_usuario,
            $pedido->estado,
            $pedido->precio_total);
        if ($conn->query($query) === TRUE) {
            $pedido->id_pedido = $pedido->id_usuario + 1;
            $result = $pedido;
        } else {
            file_put_contents("falloBD.txt",$query);
            echo "Error al insertar en la BD: " . $conn->errno . "<br>" . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    private static function actualiza($pedido){//actualizamos el pedido en la base de datos
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE pedido P SET id_usuario = '%d', estado = '%d', precio_total = '%d' WHERE P.id_pedido = '%d'",
            $pedido->real_escape_string($pedido->id_usuario),
            $pedido->real_escape_string($pedido->estado),
            $pedido->real_escape_string($pedido->precio_total),
            $pedido->id_pedido
        );
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha actualizado el pedido");
            }
            $result = true;
        } else {
            file_put_contents("falloBD.txt",$query);
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