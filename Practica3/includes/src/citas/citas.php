<?php
namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios;
use es\ucm\fdi\aw\vehiculos;
use es\ucm\fdi\aw\MagicProperties;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

Class Citas{
    use MagicProperties;

    public static function crea($id_cliente, $id_mecanico, $dia,$hora,$asunto){
        $alquiler = new Citas($id_cliente, $id_mecanico, $dia,$hora,$asunto);
        return $alquiler->guarda();
    }

    private static function crearCita($cita){
        $dia = $cita->dia;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Citas (id_cliente, id_mecanico, dia, hora, asunto)
                      VALUES ('%s', '%s', '%s', '%s', '%s')",
                      $conn->real_escape_string($cita->id_cliente),
                      $conn->real_escape_string($cita->id_mecanico),
                      $conn->real_escape_string($cita->dia),
                      $conn->real_escape_string($cita->hora), 
                      $conn->real_escape_string($cita->asunto));
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
        $query = "UPDATE Citas SET fecha=$cita->fecha, asunto=$cita->asunto WHERE id_cita=$cita->id";
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

    public static function listaCitas(){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_cliente = {$_SESSION['id']}";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }
    public static function listaCitasM($id){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_mecanico = '$id'";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }

    private $id;
    private $id_cliente;
    private $id_mecanico;
    private $fecha;
    private $asunto;
    private $dia;
    private $hora;
    private function __construct($id_cliente, $id_mecanico, $dia,$hora,$asunto, $id=null){
        $this->id = $id;
        $this->id_cliente = $id_cliente;
        $this->id_mecanico = $id_mecanico;
       
        $this->dia = $dia;
        $this->hora = $hora;


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
    public function getDia(){
        return $this->dia;
    }
    public function getHora(){
        return $this->hora;
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
            return new Citas($cita['id_cliente'], $cita['id_mecanico'], $cita['dia'],  $cita['hora'],$cita['asunto'], $cita['id_cita']);
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
                $result[] = new Citas($cita['id_cliente'], $cita['id_mecanico'], $cita['dia'], $cita['hora'], $cita['asunto'], $cita['id_cita']);
            }
            $rs->free();
        } else {
            error_log("Error al consultar la base de datos: $conn->error ");
        }
        return $result;
    }

    public static function borrar($id){
        return self::eliminarCitas($id);
    }
    private static function eliminarCitas($id){
        
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM Citas WHERE id_cita='$id'";
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

}
