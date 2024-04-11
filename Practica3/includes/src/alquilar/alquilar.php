<?php
namespace es\ucm\fdi\aw\alquilar;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios;
use es\ucm\fdi\aw\vehiculos;
use es\ucm\fdi\aw\MagicProperties;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

Class Alquilar{

    use MagicProperties;

    public static function crea($id_usuarios, $id_vehiculo, $fechaIni,$fechaFin, $precioFinal, $estado = 0){
        $alquiler = new Alquilar($id_usuarios, $id_vehiculo, $fechaIni,$fechaFin,  $precioFinal, $estado);
        return $alquiler->guarda();
    }

    private static function alquilarVehiculo($alquiler){
        $fechaInicio = $alquiler->fechaIni;
        $fechaFin = $alquiler->fechaFin;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO alquileres (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, precioFinal, estado) VALUES ($alquiler->id_usuarios, $alquiler->id_vehiculo, '$fechaInicio', '$fechaFin', $alquiler->precioFinal, 0)";
        $rs = $conn->query($query);
        if ($rs) {
            $alquiler->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $alquiler;
       
    }
    private static function actualiza($alquiler){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE alquileres SET fecha_inicio=$alquiler->fechaIni, fecha_fin=$alquiler->fechaFin WHERE id=$alquiler->id";
        $rs = $conn->query($query);
        if ($rs) {
            if ($conn->affected_rows != 1) {
                error_log("Error al actualizar el alquiler $alquiler->id");
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $alquiler;
    }


    public function guarda()
    {
        if ($this->id !== null) {
            

            return self::actualiza($this);
        }
        

        return self::alquilarVehiculo($this);
    }

    private static function buscaPorId($id_usuarios){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM alquileres WHERE id_usuario=$id_usuarios";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'], $fila['estado'],$fila['id_alquiler']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    public static function buscaPorIdAlquiler($id_alquiler){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM alquileres WHERE id_alquiler=%d", $id_alquiler);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'], $fila['estado'],$fila['id_alquiler']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function listaAlquileres($id_usuarios){
        $fechaActual = date('Y-m-d');
        $lista_alquileres = array();
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM alquileres WHERE id_usuario=$id_usuarios AND fecha_fin >= '$fechaActual'";
        $rs = $conn->query($query);
        
        if ($rs) {
            while($fila = $rs->fetch_assoc()){
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'], $fila['estado'],$fila['id_alquiler']);
                array_push($lista_alquileres, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_alquileres;
        
    }

    public static function listaTodosAlquileres(){
        $lista_alquileres = array();
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM alquileres";
        $rs = $conn->query($query);
        
        if ($rs) {
            while($fila = $rs->fetch_assoc()){
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'],     $fila['estado'],$fila['id_alquiler']);
                array_push($lista_alquileres, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_alquileres;
        
    }

    public static function comprobarFecha(){
        $lAlquileres = array();
        $lAlquileres = self::listaTodosAlquileres();
        foreach($lAlquileres as $alquileres){
            if(strtotime($alquileres->getFechaFin()) < strtotime(date('Y-m-d'))){
                self::cambiarEstado($alquileres->getId());
            }
        }

    }

    private $id;
    private $id_usuarios;
    private $id_vehiculo;
    private $fechaIni;
    private $fechaFin;
    private $precioFinal;
    private $estado;
    private function __construct($id_usuarios, $id_vehiculo, $fechaIni,$fechaFin, $precioFinal,$estado,$id = null)
    {   
        $this->id = $id;
        $this->id_usuarios = $id_usuarios;
        $this->id_vehiculo = $id_vehiculo;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->precioFinal = $precioFinal;
        $this->estado = $estado;
    }
    public function getId(){
        return $this->id;
    }
    public function getIdUsuario(){
        return $this->id_usuarios;
    }
    public function getIdVehiculo(){
        return $this->id_vehiculo;
    }
    public function getFechaIni(){
        return $this->fechaIni;
    }
    public function getFechaFin(){
        return $this->fechaFin;
    }
    public function getPrecioFinal(){
        return $this->precioFinal;
    }
    public function getEstado(){
        return $this->estado;
    }
    public static function cambiarEstado($id){
        $alquiler = self::buscaPorIdAlquiler($id);
       if($alquiler->getEstado() == 0){
           $alquiler->estado = 1;
         }else{
            $alquiler->estado = 0;
         }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE alquileres SET estado='$alquiler->estado' WHERE id_alquiler='$alquiler->id'");
        $rs = $conn->query($query);
        if ($rs) {
            if ($conn->affected_rows != 1) {
                error_log("Error al actualizar el alquiler $alquiler->id");
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $alquiler;
    }

    public static function borrar($id){
        return self::eliminarAlquiler($id);
    }
    private static function eliminarAlquiler($id){
        $alquiler = self::buscaPorIdAlquiler($id);
        $vehiculo = Vehiculo::buscaPorId($alquiler->getIdVehiculo());
        Vehiculo::cambiarDisponibilidad($vehiculo);
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM alquileres WHERE id_alquiler='$id'";
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha eliminado el alquiler");
            }
            $result = true;
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        
        return $result;


    }
    public static function historialAlquileres($id_usuarios){
        $lista_alquileres = array();
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM alquileres WHERE id_usuario=$id_usuarios AND estado=1";
        $rs = $conn->query($query);
        
        if ($rs) {
            while($fila = $rs->fetch_assoc()){
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'], $fila['estado'],$fila['id_alquiler']);
                array_push($lista_alquileres, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_alquileres;
    }
    public static function alquileresPendientesDeDevolver($id_usuarios){
        $lista_alquileres = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $fechaActual = date('Y-m-d');
        $query = "SELECT * FROM alquileres WHERE id_usuario=$id_usuarios AND estado=0 AND  fecha_fin < '$fechaActual' ";
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()){
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'], $fila['estado'],$fila['id_alquiler']);
                array_push($lista_alquileres, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_alquileres;

    }
    
}