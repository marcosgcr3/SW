<?php
namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios;
use es\ucm\fdi\aw\vehiculos;
use es\ucm\fdi\aw\MagicProperties;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

Class Citas{
    use MagicProperties;

    public static function crea($id_cliente, $id_mecanico, $fecha,$asunto){
        $alquiler = new Citas($id_cliente, $id_mecanico, $fecha,$asunto);
        return $alquiler->guarda();
    }

    private static function crearCita($cita){
        $fecha = $cita->fecha;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO Citas (id_cliente, id_mecanico, fecha, asunto) VALUES ($cita->id_cliente, $cita->id_mecanico, '$fecha', '$cita->asunto')";
        $rs = $conn->query($query);
        if ($rs) {
            $cita->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $cita;
       
    }
    private static function actualiza($cita){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE Citas SET fecha=$cita->fecha, asunto=$cita->asunto WHERE id=$cita->id";
        $rs = $conn->query($query);
        if ($rs) {
            if ($conn->affected_rows != 1) {
                error_log("Error al actualizar la cita $cita->id");
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $cita;
    }
    public function guarda()
    {
        if ($this->id !== null) {
            

            return self::actualiza($this);
        }
        return self::crearCita($this);
    }
    private $id;
    private $id_cliente;
    private $id_mecanico;
    private $fecha;
    private $asunto;
    private function __construct($id_cliente, $id_mecanico, $fecha,$asunto, $id=null){
        $this->id = $id;
        $this->id_cliente = $id_cliente;
        $this->id_mecanico = $id_mecanico;
        $this->fecha = $fecha;
        $this->asunto = $asunto;
    }
    public function getId(){
        return $this->id;
    }
    public function getIdCliente(){
        return $this->id_cliente;
    }
    public function getIdMecanico(){
        return $this->id_mecanico;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getAsunto(){
        return $this->asunto;
    }
    public static function buscaPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM Citas WHERE id_cita=$id";
        $rs = $conn->query($query);
        if ($rs) {
            if ($rs->num_rows == 0) {
                return null;
            }
            $cita = $rs->fetch_assoc();
            $rs->free();
            return new Citas($cita['id_cliente'], $cita['id_mecanico'], $cita['fecha'], $cita['asunto'], $cita['id_cita']);
        } else {
            error_log("Error al consultar la base de datos: $conn->error ");
            return null;
        }
    }
    public static function buscaPorCliente($id_cliente){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM Citas WHERE id_cliente=$id_cliente";
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while($cita = $rs->fetch_assoc()){
                $result[] = new Citas($cita['id_cliente'], $cita['id_mecanico'], $cita['fecha'], $cita['asunto'], $cita['id_cita']);
            }
            $rs->free();
        } else {
            error_log("Error al consultar la base de datos: $conn->error ");
        }
        return $result;
    }
}
