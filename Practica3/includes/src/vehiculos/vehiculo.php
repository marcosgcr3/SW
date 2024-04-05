<?php
 namespace es\ucm\fdi\aw\vehiculos;

    use es\ucm\fdi\aw\Aplicacion;
    use es\ucm\fdi\aw\MagicProperties;
    
class Vehiculo
{
    
    use MagicProperties;

    public static function crea($matricula,$marca, $modelo, $precio,$year, $imagen)
    {   
      
        $producto = new Vehiculo($matricula, $marca,$modelo, $precio,$year, 'si', $imagen);
        
        return $producto->guarda();
    }
    public static function buscaPorMatricula($matricula)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM vehiculos WHERE matricula='$matricula'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Vehiculo( $fila['matricula'], $fila['marca'], $fila['modelo'], $fila['precio'], $fila['year'],$fila['disponibilidad'], $fila['imagen'], $fila['id_vehiculo']);
            }
            $rs->free();
        } else {
            error_log("No se encontró ningún vehículo con la matrícula: $matricula");
        }
        return $result;
    }

    public static function buscaPorMarca($marca)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM vehiculos WHERE marca='$marca'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Vehiculo( $fila['matricula'], $fila['marca'], $fila['modelo'], $fila['precio'],$fila['year'], $fila['disponibilidad'], $fila['imagen']. $fila['id_vehiculo']);
            }
            $rs->free();
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorId($id_vehiculo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM vehiculos WHERE id_vehiculo='$id_vehiculo'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Vehiculo( $fila['matricula'], $fila['marca'], $fila['modelo'], $fila['precio'], $fila['year'],$fila['disponibilidad'], $fila['imagen'], $fila['id_vehiculo']);
            }
            $rs->free();
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function listaVehiculos()
    {
        $lista_vehiculos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM vehiculos";
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $vehiculo = new Vehiculo( $fila['matricula'], $fila['marca'], $fila['modelo'], $fila['precio'], $fila['year'],$fila['disponibilidad'], $fila['imagen'], $fila['id_vehiculo']);
                array_push($lista_vehiculos, $vehiculo);
            }
            $rs->free();
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $lista_vehiculos;
    }
    public static function listaVehiculosDisponibles()
    {
        $lista_vehiculos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM vehiculos WHERE disponibilidad='si' ";
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $vehiculo = new Vehiculo( $fila['matricula'], $fila['marca'], $fila['modelo'], $fila['precio'], $fila['year'],$fila['disponibilidad'], $fila['imagen'], $fila['id_vehiculo']);
                array_push($lista_vehiculos, $vehiculo);
            }
            $rs->free();
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $lista_vehiculos;
    }
    private $id_vehiculo;
    private $matricula;
    private $marca;
    private $modelo;
    private $precio;
    private $year;
    private $disponibilidad;
    private $imagen;

    public function __construct($matricula, $marca, $modelo, $precio,$year, $disponibilidad, $imagen, $id_vehiculo=null)
    {
        $this->id_vehiculo = $id_vehiculo;
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->precio = $precio;
        $this->year = $year;
        $this->disponibilidad = $disponibilidad;
        $this->imagen = $imagen;

    }

    public function getId()
    {
        return $this->id_vehiculo;
    }
    public function getMatricula()
    {
        return $this->matricula;
    }
    public function getMarca()
    {
        return $this->marca;
    }
    public function getModelo()
    {
        return $this->modelo;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getYear()
    {
        return $this->year;
    }

    public function guarda()
    {
        if ($this->id_vehiculo != null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function actualiza($vehiculo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE vehiculos V SET matricula='%s', marca='%s', modelo='%s', precio='%s', year='%s', disponibilidad='%s', imagen='%s' WHERE V.id_vehiculo=%d"
            , $vehiculo->matricula
            , $vehiculo->marca
            , $vehiculo->modelo
            , $vehiculo->precio
            , $vehiculo->year
            , $vehiculo->disponibilidad
            , $vehiculo->imagen
            , $vehiculo->id_vehiculo
        );
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                error_log("Error Aplicacion: No se ha actualizado la disponibilidad");
            }
            $result = true;
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }   

    public static function comprobarDisponibilidadTodos()
{
    $conn = Aplicacion::getInstance()->getConexionBd();


    $fechaActual = date('Y-m-d');
 
   
    $listaVehiculos = self::listaVehiculos();

    foreach ($listaVehiculos as $vehiculo) {
        
        $query = sprintf("SELECT * FROM alquileres WHERE id_vehiculo = '%s' AND fecha_inicio <= '%s' AND fecha_fin >= '%s'", $vehiculo->getId(), $fechaActual, $fechaActual);
        $rs = $conn->query($query);
       
        if ($rs && $rs->num_rows > 0) {
            
            $vehiculo->disponibilidad = 'no';
        } else {
            $query_last_rental = sprintf("SELECT estado FROM alquileres WHERE id_vehiculo = '%s' ", $vehiculo->getId());
            $rs_last_rental = $conn->query($query_last_rental);

            if ($rs_last_rental && $rs_last_rental->num_rows > 0) {
                $last_rental = $rs_last_rental->fetch_assoc();
                if ($last_rental['estado'] == 0) {
                    // Si el estado del último alquiler fue 0, mantener la disponibilidad del vehículo sin cambios
                    continue;
                }
            }

            // Si no hay alquileres activos y el estado del último alquiler no fue 0, el vehículo está disponible
            $vehiculo->disponibilidad = 'si';
            
        }

       
        $query = sprintf("UPDATE vehiculos SET disponibilidad='%s' WHERE id_vehiculo ='%s'", $vehiculo->getDisponibilidad(), $vehiculo->getId());
        $rs = $conn->query($query);
        if ($rs) {
            if ($conn->affected_rows != 1) {
                error_log("Error al cambiar la disponibilidad del vehiculo");
            }
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
    }
}
    public static function cambiarDisponibilidad($vehiculo)
{
    $conn = Aplicacion::getInstance()->getConexionBd();

    $fechaActual = date('Y-m-d');

    
    $query = sprintf("SELECT * FROM alquileres WHERE id_vehiculo = '%s' AND fecha_inicio <= '%s' AND fecha_fin >= '%s'", $vehiculo->id_vehiculo, $fechaActual, $fechaActual);
    $rs = $conn->query($query);
    
    if ($rs && $rs->num_rows > 0) {
        
        $vehiculo->disponibilidad = 'no';
    } else {
       
        $vehiculo->disponibilidad = 'si';
    }
    $query = sprintf("UPDATE vehiculos SET disponibilidad='%s' WHERE id_vehiculo ='%s'", $vehiculo->disponibilidad, $vehiculo->id_vehiculo);
    $rs = $conn->query($query);
    if ($rs) {
        if ($conn->affected_rows != 1) {
            error_log("Error al cambiar la disponibilidad del vehiculo");
        }
    } else {
        error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
    }
    return $vehiculo;
}
    private static function inserta($vehiculo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO vehiculos (matricula, marca, modelo, precio, year ,disponibilidad, imagen) 
        VALUES ('$vehiculo->matricula', '$vehiculo->marca', '$vehiculo->modelo', '$vehiculo->precio', '$vehiculo->year', '$vehiculo->disponibilidad', '$vehiculo->imagen')");
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            file_put_contents("falloAplicacion.txt", $query);
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    private static function eliminarVehiculo($matricula){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM vehiculos WHERE matricula='$matricula'";
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha eliminado el vehiculo");
            }
            $result = true;
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function borrar($matricula){
        return self::eliminarVehiculo($matricula);
    }

}