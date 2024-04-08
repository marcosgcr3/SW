<?php
namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios;
use es\ucm\fdi\aw\vehiculos;
use es\ucm\fdi\aw\MagicProperties;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

Class Citas{
    use MagicProperties;

    public static function crea($id_cliente, $id_mecanico, $dia,$hora,$asunto, $estado){
        $alquiler = new Citas($id_cliente, $id_mecanico, $dia,$hora,$asunto, $estado);
        return $alquiler->guarda();
    }

    private static function crearCita($cita){
        $dia = $cita->dia;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Citas (id_cliente, id_mecanico, dia, hora, asunto, estado)
                      VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
                      $conn->real_escape_string($cita->id_cliente),
                      $conn->real_escape_string($cita->id_mecanico),
                      $conn->real_escape_string($cita->dia),
                      $conn->real_escape_string($cita->hora), 
                      $conn->real_escape_string($cita->asunto),
                      $conn->real_escape_string($cita->estado));
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
    public static function listaCitasMecanico($id_mecanico){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_mecanico = $id_mecanico";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['estado'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }
    public static function listaCitasMecanicoEnUnDia($id_mecanico, $dia){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_mecanico = $id_mecanico AND dia = '$dia'";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['estado'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        usort($lista_citas, function($a, $b) {
            return strcmp($a->getHora(), $b->getHora());
        });
        return $lista_citas;
    }
    public static function listaCitas(){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_cliente = {$_SESSION['id']} AND estado = 0";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['estado'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }

    public static function listaTodasCitas(){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['estado'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }

    public static function comprobarFecha(){
        $lCitas = array();
        $lCitas = self::listaTodasCitas();
        foreach($lCitas as $citas){
            if(strtotime($citas->getDia()) < strtotime(date('Y-m-d'))){
                self::borrar($citas->getId());
            }
            else if(strtotime($citas->getDia()) == strtotime(date('Y-m-d'))){
                if($citas->getHora() < date('G'))
                    self::borrar($citas->getId());
            }
        }

    }

    public static function listaCitasM($id){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_mecanico = '$id'";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['estado'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }
    public static function diasConCitas($idMecanico) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        
    
        // Consultar los días en los que el mecánico tiene citas programadas
        $query = "SELECT DISTINCT dia FROM Citas WHERE id_mecanico = $idMecanico";
        $rs = $conn->query($query);
    
        if ($rs) {
            $diasConCitas = array();
            while ($fila = $rs->fetch_assoc()) {
                $diasConCitas[] = $fila['dia'];
            }
            $rs->free();
    
           
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return array();
        } 
        sort($diasConCitas);
        return $diasConCitas;
    }
    
    private $id;
    private $id_cliente;
    private $id_mecanico;
    private $fecha;
    private $asunto;
    private $dia;
    private $hora;
    private $estado;
    private function __construct($id_cliente, $id_mecanico, $dia,$hora,$asunto, $estado, $id=null){
        $this->id = $id;
        $this->id_cliente = $id_cliente;
        $this->id_mecanico = $id_mecanico;
       
        $this->dia = $dia;
        $this->hora = $hora;


        $this->asunto = $asunto;
        $this->estado = $estado;
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
    public function getEstado(){
        return $this->estado;
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
            return new Citas($cita['id_cliente'], $cita['id_mecanico'], $cita['dia'],  $cita['hora'],$cita['asunto'], $cita['estado'], $cita['id_cita']);
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
                $result[] = new Citas($cita['id_cliente'], $cita['id_mecanico'], $cita['dia'], $cita['hora'], $cita['asunto'], $fila['estado'], $cita['id_cita']);
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

    public static function cambiarEstado($cita){
        $cita->estado = ($cita->estado == 0) ? 1 : 0;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE citas SET estado='$cita->estado'
                             WHERE id_cita ='$cita->id'");
        $rs = $conn->query($query);
        if ($rs) {
            if ($conn->affected_rows != 1) {
                error_log("Error al cambiar el estado de la cita");
            }
        } else {
            error_log("Error Aplicacion ({$conn->errno}): {$conn->error}");
        }
        return $vehiculo;
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

    public static function listaCitasHistorial($id_usuario){
        $lista_citas = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Citas WHERE id_cliente = $id_usuario AND estado = 1";
        $rs = $conn->query($sql);

        if($rs){
            while($fila = $rs->fetch_assoc()){
                $result = new Citas($fila['id_cliente'], $fila['id_mecanico'], $fila['dia'], $fila['hora'], $fila['asunto'], $fila['estado'], $fila['id_cita']);
                array_push($lista_citas, $result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_citas;
    }

}
