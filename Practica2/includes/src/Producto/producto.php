<?php

class Producto
{



    
   
    
    public static function crea($nombre, $precio, $descripcion, $unidades, $imagen)
    {
        $producto = new Producto($nombre, $precio, $descripcion, $unidades, $imagen);
        
        return $producto->guarda();
    }
    public static function buscaPorNombre($nombre)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos WHERE nombre='$nombre'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto( $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['unidades'], $fila['imagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id_producto)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos WHERE id_producto=$id_producto";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto( $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['unidades'], $fila['imagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    
   

    private $id_producto;
    
    private $nombre;

    private $precio;

    private $descripcion;

    private $unidades;

    private $imagen;


    private function __construct($nombre, $precio, $descripcion, $unidades, $imagen,$id_producto = null)
    {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->unidades = $unidades;
        $this->imagen = $imagen;
    }
   
    public function getNombre()
    {
        return $this->nombre;
    }
    public function guarda()
    {
        if ($this->id_producto != null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    private static function actualiza($producto)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("UPDATE productos P SET unidades = '$producto->unidades' WHERE p.id=$producto->id_producto"
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
   
    private static function inserta($producto)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
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