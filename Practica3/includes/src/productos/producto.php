<?php
    namespace es\ucm\fdi\aw\productos;

    use es\ucm\fdi\aw\Aplicacion;
    use es\ucm\fdi\aw\MagicProperties;

    
class Producto
{

    use MagicProperties;

    
   
    
    public static function crea($nombre, $precio, $descripcion, $unidades, $imagen)
    {
        $producto = new Producto($nombre, $precio, $descripcion, $unidades, $imagen);
        
        return $producto->guarda();
    }

    public static function buscaPorNombre($nombre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos WHERE nombre='$nombre'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['unidades'], $fila['imagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function devolverId($nombre){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT id_producto FROM productos WHERE nombre='$nombre'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = $fila['id_producto'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorId($id_producto)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos WHERE id_producto=$id_producto";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['unidades'], $fila['imagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    public static function listaProductos($id_pedido){//devuelve una lista con todos los productos del pedido
        $lista_productos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT p.id_producto, p.nombre, p.precio, p.descripcion, p.imagen, pp.cantidad
                            FROM productos p 
                            INNER JOIN pedido_producto pp ON p.id_producto = pp.id_producto
                            WHERE pp.id_pedido = '%d'", $id_pedido );
        $rs = $conn->query($query);
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $producto = new Producto($row['nombre'], $row['precio'], $row['descripcion'], $row['cantidad'], $row['imagen']);
                array_push($lista_productos, $producto);
            }
            $rs->free();
        }
        else{
            echo "No hay productos en la base de datos";
        }
        return $lista_productos;

    }
    public static function listaProducto(){//devuelve una lista con todos los productos de la BD

        $lista_productos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos";
        $rs = $conn->query($query);
        
        if($rs -> num_rows > 0){
            while($row = $rs->fetch_assoc()){
                $producto = new Producto($row['nombre'], $row['precio'], $row['descripcion'], $row['unidades'], $row['imagen'], $row['id_producto']);
                array_push($lista_productos, $producto);
            }
            $rs->free();
        }
        else{
            echo "No hay productos en la base de datos";
        }
        return $lista_productos;
    }

    private $id_producto;
    
    private $nombre;

    private $precio;

    private $descripcion;

    private $unidades;

    private $imagen;


    private function __construct($nombre, $precio, $descripcion, $unidades, $imagen,$id_producto = null)
    {
        $this->id_producto = $id_producto !== null ? intval($id_producto) : null;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->unidades = $unidades;
        $this->imagen = $imagen;
    }

    public function setUnidades($unidades){
        $this->unidades = $unidades;
    }

    public function getId()
    {
        return $this->id_producto;
    }
   
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getUnidades()
    {
        return $this->unidades;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function guarda()
    {
        if ($this->nombre != null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    private static function actualiza($producto)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE productos p SET unidades = '$producto->unidades' WHERE p.nombre='$producto->nombre'"
        );
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha actualizado el producto");
            }
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
       
        
        
        return $result;
    }
    public static function borrar($nombre){
        return self::eliminarProducto($nombre);
    }
    private static function eliminarProducto($nombre){
        
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        //$query = "DELETE FROM productos WHERE nombre='$nombre'";
        $query = "UPDATE productos SET unidades = '0' WHERE nombre='$nombre'";
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha eliminado el producto");
            }
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
   
    private static function inserta($producto)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO productos(nombre, precio, descripcion, unidades, imagen)
            VALUES ('%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($producto->nombre),
            $conn->real_escape_string($producto->precio),
            $conn->real_escape_string($producto->descripcion),
            $conn->real_escape_string($producto->unidades),
            $conn->real_escape_string($producto->imagen));
    
        if ($conn->query($query)) {
            $result = $producto;
        } else {
            file_put_contents("falloBD.txt", $query);
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    

}
