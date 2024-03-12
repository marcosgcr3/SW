<?php
namespace es\ucm\fdi\aw\alquilar;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios;
use es\ucm\fdi\aw\vehiculos;
use es\ucm\fdi\aw\MagicProperties;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

Class Alquilar{

    use MagicProperties;

    public static function crea($id_usuarios, $id_vehiculo, $fechaIni,$fechaFin, $precioFinal){
        $alquiler = new Alquilar($id_usuarios, $id_vehiculo, $fechaIni,$fechaFin,  $precioFinal);
        return $alquiler->guarda();
    }

    private static function alquilarVehiculo($alquiler){
        $fechaInicio = $alquiler->fechaIni;
        $fechaFin = $alquiler->fechaFin;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO Alquileres (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, precioFinal) VALUES ($alquiler->id_usuarios, $alquiler->id_vehiculo, '$fechaInicio', '$fechaFin', $alquiler->precioFinal)";
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
        $query = "UPDATE Alquileres SET fecha_inicio=$alquiler->fechaIni, fecha_fin=$alquiler->fechaFin WHERE id=$alquiler->id";
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
        $query = "SELECT * FROM Alquileres WHERE id_usuario=$id_usuarios";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Alquilar($fila['id_usuario'], $fila['id_vehiculo'], $fila['fecha_inicio'], $fila['fecha_fin'], $fila['precioFinal'],$fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private $id;
    private $id_usuarios;
    private $id_vehiculo;
    private $fechaIni;
    private $fechaFin;
    private $precioFinal;
    private function __construct($id_usuarios, $id_vehiculo, $fechaIni,$fechaFin, $precioFinal,$id = null)
    {   
        $this->id = $id;
        $this->id_usuarios = $id_usuarios;
        $this->id_vehiculo = $id_vehiculo;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->precioFinal = $precioFinal;
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


}