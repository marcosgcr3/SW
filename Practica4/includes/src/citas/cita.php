<?php

namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion as App;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\dao\DataAccessException;
use \DateTime;
use DateInterval;

/**
 * Representa un Cita de calendario.
 */
class Cita implements \JsonSerializable
{

    /**
     * Busca todos los Citas de un usuario con id $id_mecanico.
     *
     * @param int $id_mecanico Id del usuario a buscar.
     *
     * @return array[Cita] Lista de Citas del usuario con id $id_mecanico.
     */
    public static function buscaTodasCitas(int $id_mecanico)
    {
        if (!$id_mecanico) {
            throw new \BadMethodCallException('$id_mecanico no puede ser nulo.');
        }

        $result = [];
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf('SELECT C.id, C.id_cliente, C.id_mecanico AS id_mecanico, C.title, C.startDate AS start, C.endDate AS end FROM citas C WHERE C.id_mecanico = %d'
            , $id_mecanico);

            $rs = $conn->query($query);
            if ($rs) {
                while($fila = $rs->fetch_assoc()) {
                    $e = new Cita();
                    $e->asignaDesdeDiccionario($fila);
                    $result[] = $e;
                }
                $rs->free();
            } else {
                throw new DataAccessException("Se esperaba 1 Cita y se han obtenido: ".$rs->num_rows);
            }
            return $result;
        }

    /**
     * Busca un Cita con id $idCita.
     *
     * @param int $idCita Id del Cita a buscar.
     *
     * @return Cita Cita encontrado.
     */
    public static function buscaPorId(int $idCita)
    {
        if (!$idCita) {
            throw new \BadMethodCallException('$idCita no puede ser nulo.');
        }

        $result = null;
        $app = App::getSingleton();
        $conn = $app->getConexionBd();
        $query = sprintf("SELECT C.id, C.id_cliente, C.title, C.id_mecanico, C.startDate AS start, C.endDate AS end FROM citas C WHERE C.id = %d", $idCita);
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while($fila = $rs->fetch_assoc()) {
                $result = new Cita();
                $result->asignaDesdeDiccionario($fila);
            }
            $rs->free();
        } else {
            if ($conn->affected_rows == 0) {
                throw new CitaNoEncontradoException("No se ha encontrado el Cita: ".$idCita); 
            }
            throw new DataAccessException("Se esperaba 1 Cita y se han obtenido: ".$rs->num_rows);
        }
        return $result;
    }
  
    /**
     * Busca los Citas de un usuario con id $id_mecanico en el rango de fechas $start y $end (si se proporciona).
     *
     * @param int $id_mecanico Id del usuario para el que se buscarán los Citas.
     * @param DateTime $start Fecha a partir de la cual se buscarán Citas (@link MYSQL_DATE_TIME_FORMAT)
     * @param DateTime|null $end Fecha hasta la que se buscarán Citas (@link MYSQL_DATE_TIME_FORMAT)
     *
     * @return array[Cita] Lista de Citas encontrados.
     */
    public static function cuentaMecanicosDistintos()
{
    $result = null;
    $conn = App::getInstance()->getConexionBd();
    
    $query = "SELECT COUNT(DISTINCT id) AS num_mecanicos FROM usuarios WHERE rol= 'mecanico'";
    
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $numMecanicos = (int) $row['num_mecanicos'];
        $result->free();
        return $numMecanicos;
    } else {
        throw new DataAccessException("Error al contar mecánicos distintos: " . $conn->error);
    }
}


public static function fechasDisponibles(int $id_cliente, DateTime $start, DateTime $end)
{
    if (!$id_cliente) {
        throw new \BadMethodCallException('$id_cliente  no puede ser nulo.');
    }
    $startDate = $start->format(self::MYSQL_DATE_TIME_FORMAT);
    if (!$startDate) {
        throw new \BadMethodCallException('$start no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
    }
    
    $endDate = null;
    if ($end) {
        $endDate =  $end->format(self::MYSQL_DATE_TIME_FORMAT);
        if (!$endDate) {
            throw new \BadMethodCallException('$end no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
        }
    }
    
    $conn = App::getInstance()->getConexionBd();
    
    // Inicializar el resultado como null
    $result = [];
    
    // Iterar día por día y hora por hora dentro del rango de fechas
    $currentDate = clone $start;
    while ($currentDate <= $end) {
        $currentDateTime = $currentDate->format(self::MYSQL_DATE_TIME_FORMAT);
        $currentDateF = clone $currentDate;
        $currentDateF->add(new DateInterval('PT1H'));
        $currentDateTimeF = $currentDateF->format(self::MYSQL_DATE_TIME_FORMAT);
        // Contar el número de Citas para el día y hora actual
        $query = sprintf("SELECT COUNT(*) AS num_Citas FROM citas WHERE '%s' >= startDate AND '%s' <= endDate", $currentDateTime, $currentDateTimeF );
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $numCitas = intval($fila['num_Citas']);
        
        // Obtener el número de mecánicos
        $numMecanicos =self::cuentaMecanicosDistintos();
        
        // Si el número de Citas es igual al número de mecánicos, establecer el Cita "ocupado"
        if ($numCitas == $numMecanicos) {
            $ocupado = new Cita();
            $ocupado->setTitle("Ocupado");
            $ocupado->setStart(new DateTime($currentDateTime));
            $ocupado->setEnd(new DateTime($currentDateTimeF));
            $result[] = $ocupado;
        }else{
            $query = sprintf("SELECT id, id_cliente, estado, title, id_mecanico, startDate FROM citas WHERE id_cliente =%d AND '%s' >= startDate AND '%s' <= endDate ",$id_cliente, $currentDateTime, $currentDateTimeF );
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if($fila){
                $ocupado = new Cita();
                $ocupado->setTitle($fila['title']);
                $ocupado->setStart(new DateTime($currentDateTime));
                $ocupado->setEnd(new DateTime($currentDateTimeF));
                $ocupado->setEstado($fila['estado']);
                $nombreMecanico = Usuario::buscaPorId($fila['id_mecanico']);
                $ocupado-> __set('nombre',$nombreMecanico->getNombre());
                $result[] = $ocupado;
                $rs->free();
            }
        }
        
        // Incrementar la fecha y hora
        $currentDate->add(new DateInterval('PT1H'));
    }
    
    
    return $result;
}
    
    public static function buscaEntreFechas(int $id_mecanico, DateTime $start, DateTime $end)
    {
        if (!$id_mecanico) {
            throw new \BadMethodCallException('$id_mecanico no puede ser nulo.');
        }
        
        $startDate = $start->format(self::MYSQL_DATE_TIME_FORMAT);
        if (!$startDate) {
            throw new \BadMethodCallException('$diccionario[\'start\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
        }
        
        $endDate = null;
        if ($end) {
            $endDate =  $end->format(self::MYSQL_DATE_TIME_FORMAT);
            if (!$endDate) {
                throw new \BadMethodCallException('$diccionario[\'end\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
            }
        }
        
        $conn = App::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT C.id, C.id_cliente, C.estado, C.title, C.id_mecanico, C.startDate  AS start, C.endDate AS end  FROM citas C WHERE C.id_mecanico=%d AND C.estado != 2 AND C.startDate >= '%s'", $id_mecanico, $startDate);
        if ($endDate) {
            $query = sprintf($query . " AND C.startDate <= '%s'", $endDate);
        }
        
        $result = [];
        
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $e = new Cita();
                $e->asignaDesdeDiccionario($fila);
                $result[] = $e;
            }
            foreach($result as $Cita){
                $nombreMecanico = Usuario::buscaPorId($Cita->getid_mecanico());
                $Cita-> __set('nombre',$nombreMecanico->getNombre());
            }
            $rs->free();
        }
        return $result;
    }
    public static function cambiarEstado(int $idCita, int $estado)
    {
        if (!$idCita) {
            throw new \BadMethodCallException('$idCita no puede ser nulo.');
        }
        $result = false;
        $conn = App::getInstance()->getConexionBd();
        $query = sprintf("UPDATE citas E SET estado=%d WHERE E.id = %d"
            , $estado
                , $idCita);      
        $result = $conn->query($query);
        if ($result) {
            $result = true;
        } else {
            throw new DataAccessException("Se han actualizado más de 1 fila cuando sólo se esperaba 1 actualización: ".$conn->affected_rows);
        }
        return $result;
    }
    public static function misCitas(int $id_cliente, DateTime $start, DateTime $end){
        if (!$id_cliente) {
            throw new \BadMethodCallException('$id_cliente no puede ser nulo.');
        }
        $startDate = $start->format(self::MYSQL_DATE_TIME_FORMAT);
        if (!$startDate) {
            throw new \BadMethodCallException('$start no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
        }
        
        $endDate = null;
        if ($end) {
            $endDate =  $end->format(self::MYSQL_DATE_TIME_FORMAT);
            if (!$endDate) {
                throw new \BadMethodCallException('$end no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
            }
        }
        
        $conn = App::getInstance()->getConexionBd();
        
        $result = [];
        
        $query = sprintf("SELECT C.id, C.id_cliente, C.estado, C.title, C.id_mecanico, C.startDate  AS start, C.endDate AS end  FROM citas C WHERE C.id_cliente=%d AND C.startDate >= '%s'", $id_cliente, $startDate);
        if ($endDate) {
            $query = sprintf($query . " AND C.startDate <= '%s'", $endDate);
        }
        
        $result = [];
        
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $e = new Cita();
                $e->asignaDesdeDiccionario($fila);
                $result[] = $e;
            }
            foreach($result as $Cita){
                $nombreMecanico = Usuario::buscaPorId($Cita->getid_mecanico());
                $Cita-> __set('nombre',$nombreMecanico->getNombre());
            }
            $rs->free();
        }
        return $result;
    }
    
    /**
     * Guarda o actualiza un Cita $Cita en la BD.
     *
     * @param Cita $Cita Cita a guardar o actualizar.
     */
    public static function guardaOActualiza(Cita $Cita)
    {
        if (!$Cita) {
            throw new \BadMethodCallException('$Cita no puede ser nulo.');
        }
        $result = false;
        $conn = App::getInstance()->getConexionBd();
        if (!$Cita->id) {
            $query = sprintf("INSERT INTO citas (id_cliente, id_mecanico, title, startDate, endDate, estado) VALUES (%d, %d,'%s', '%s', '%s', %d)"
                , $Cita->id_cliente
                , $Cita->id_mecanico
                    , $conn->real_escape_string($Cita->title)
                        , $Cita->start->format(self::MYSQL_DATE_TIME_FORMAT)
                            , $Cita->end->format(self::MYSQL_DATE_TIME_FORMAT)
                                , $Cita->estado);

            $result = $conn->query($query);
            if ($result) {
                $Cita->id = $conn->insert_id;
                $result = $Cita;
            } else {
                throw new DataAccessException("No se ha podido guardar el Cita");
            }
        } else {
            $query = sprintf("UPDATE citas E SET id_mecanico=%d, title='%s', startDate='%s', endDate='%s' WHERE E.id = %d"
                , $Cita->id_mecanico
                    , $conn->real_escape_string($Cita->title)
                        , $Cita->start->format(self::MYSQL_DATE_TIME_FORMAT)
                            , $Cita->end->format(self::MYSQL_DATE_TIME_FORMAT)
                                , $Cita->id);      
            $result = $conn->query($query);
            if ($result) {
                $result = $Cita;
            } else {
                throw new DataAccessException("Se han actualizado más de 1 fila cuando sólo se esperaba 1 actualización: ".$conn->affected_rows);
            }
        }

        return $result;
    }
  
    /**
     * Borra un Cita id $idCita.
     *
     * @param int $idCita Id del Cita a borrar.
     *
     */
    public static function borraPorId(int $idCita)
    {
        if (!$idCita) {
            throw new \BadMethodCallException('$idCita no puede ser nulo.');
        }
        $result = false;
        $conn = App::getInstance()->getConexionBd();
        
        $query = sprintf('DELETE FROM citas WHERE id=%d', $idCita);
        $result = $conn->query($query);
        if ($result && $conn->affected_rows == 1) {
            $result = true;
        } else {
            if ($conn->affected_rows == 0) {
                throw new CitaNoEncontradoException("No se ha encontrado el Cita: ".$idCita); 
            }
            throw new DataAccessException("Se esperaba borrar 1 fila y se han borrado: ".$conn->affected_rows); 
        }
        return $result;
    }
  
    /**
     * Crear un Cita asociado a un usuario $id_mecanico y un título $title.
     * El comienzo es la fecha y hora actual del sistema y el fin es una hora más tarde.
     *
     * @param int $id_mecanico Id del propietario del Cita.
     * @param string $title Título del Cita.
     *
     */
    public static function creaSimple(int $id_cliente, int $id_mecanico, string $title)
    {
        $start = new \DateTime();
        $end = $start->add(new \DateInterval('PT1H'));
        return self::creaDetallado($id_cliente, $id_mecanico, $title, $start, $end, 0);
    }
  
    /**
     * Crear un Cita asociado a un usuario $id_mecanico, un título $title y una fecha y hora de comienzo.
     * El fin es una hora más tarde de la hora de comienzo.
     *
     * @param int $id_mecanico Id del propietario del Cita.
     * @param string $title Título del Cita.
     * @param DateTime $start Fecha y horas de comienzo.
     */
    public static function creaComenzandoEn(int $id_cliente, int $id_mecanico, string $title, \DateTime $start)
    {    
        if (empty($start)) {
            throw new \BadMethodCallException('$start debe ser un timestamp valido no nulo');
        }

        $end = $start->add(new \DateInterval('PT1H'));
        return self::creaDetallado($id_cliente, $id_mecanico, $title, $start, $end, 0);
    }
  
    /**
     * Crear un Cita asociado a un usuario $id_mecanico, un título $title y una fecha y hora de comienzo y fin.
     *
     * @param int $id_mecanico Id del propietario del Cita.
     * @param string $title Título del Cita.
     * @param DateTime $start Fecha y horas de comienzo.
     * @param DateTime $end Fecha y horas de fin.
     */
    public static function creaDetallado(int $id_cliente ,int $id_mecanico, string $title, \DateTime $start, \DateTime $end, int $estado)
    {
        $e = new Cita();
        $e->setid_cliente($id_cliente);
        $e->setid_mecanico($id_mecanico);
        $e->setTitle($title);
        $e->setStart($start);
        $e->setEnd($end);
        $e->setEstado($estado);
        return self::guardaOActualiza($e);
    }

    /**
     * Crear un Cita un Cita a partir de un diccionario PHP.
     * Como por ejemplo array("id_mecanico" => (int)1, "title" => "Descripcion"
     *   , "start" => "2019-04-29 00:00:00", "end" => "2019-04-30 00:00:00")
     *
     * @param array $diccionario Array / map / diccionario PHP con los datos del Cita a crear.
     *
     * @return Cita Devuelve el Cita creado.
     */
    public static function creaDesdeDicionario(array $diccionario)
    {
        $e = new Cita();
        $e->asignaDesdeDiccionario($diccionario, ['id_cliente', 'id_mecanico', 'title', 'start', 'end','estado']);
        return $e;
    }
    
    /**
     * Comprueba si $start y $end son fechas y además $start es anterior a $end.
     */
    private static function compruebaConsistenciaFechas(\DateTime $start, \DateTime $end)
    {
        if (!$start) {
            throw new \BadMethodCallException('$start no puede ser nula');
        }
        
        if (!$end) {
            throw new \BadMethodCallException('$end no puede ser nula');
        }

        if ($start >= $end) {
            throw new \BadMethodCallException('La fecha de comienzo $start no puede ser posterior a la de fin $end.');
        }
    }

    /**
     * @param int Longitud máxima del título de un Cita.
     */
    const TITLE_MAX_SIZE = 255;

    /**
     * @param string Formato de fecha y hora compatible con MySQL.
     */
    const MYSQL_DATE_TIME_FORMAT= 'Y-m-d H:i:s';

    /**
     * @param array[string] Nombre de las propiedades de la clase.
     */
    const PROPERTIES = ['id', 'id_cliente', 'id_mecanico', 'nombre' , 'title', 'start', 'end', 'estado'];
    
    private $id;

    private $id_cliente;

    private $estado;
    private $id_mecanico;
    private $nombre;

    private $title;

    private $start;

    private $end;

    private function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }


    public function getid_mecanico()
    {
        return $this->id_mecanico;
    }

    public function setid_mecanico(int $id_mecanico)
    {
        if (is_null($id_mecanico)) {
            throw new \BadMethodCallException('$id_mecanico no puede ser una cadena vacía o nulo');
        }
        $this->id_mecanico = $id_mecanico;
    }
    public function getid_cliente()
    {
        return $this->id_cliente;
    }
    public function setid_cliente(int $id_cliente){
        if (is_null($id_cliente)) {
            throw new \BadMethodCallException('$id_cliente no puede ser una cadena vacía o nulo');
        }
        $this->id_cliente = $id_cliente;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado(int $estado)
    {
        if (is_null($estado)) {
            throw new \BadMethodCallException('$estado no puede ser una cadena vacía o nulo');
        }
        $this->estado = $estado;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        if (is_null($title)) {
            throw new \BadMethodCallException('$title no puede ser una cadena vacía o nulo');
        }

        if (mb_strlen($title) > self::TITLE_MAX_SIZE) {
            throw new \BadMethodCallException('$title debe tener como longitud máxima: '.self::TITLE_MAX_SIZE);
        }
        $this->title = $title;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart(\DateTime $start)
    {      
        if (empty($start)) {
            throw new \BadMethodCallException('$start debe ser un timestamp valido no nulo');
        }
        if (! is_null($this->end) ) {
            self::compruebaConsistenciaFechas($start, $this->end);
        }
        $this->start = $start;
    }

    public function getEnd()
    {    
        if (empty($end)) {
            throw new \BadMethodCallException('$end debe ser un timestamp valido no nulo');
        }

        return $this->end;
    }

    public function setEnd(\DateTime $end)
    {      
        if (empty($end)) {
            throw new \BadMethodCallException('$end debe ser un timestamp valido no nulo');
        }

        self::compruebaConsistenciaFechas($this->start, $end);
        $this->end = $end;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
   
       
    /**
     * Método utilizado por la función de PHP json_encode para serializar un objeto que no tiene atributos públicos.
     *
     * @return Devuelve un objeto con propiedades públicas y que represente el estado de este Cita.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $o = new \stdClass();
        $o->id = $this->id;
        $o->id_cliente = $this->id_cliente;
        $o->id_mecanico = $this->id_mecanico;
        $o->title = $this->title;
        $o->start = $this->start->format(self::MYSQL_DATE_TIME_FORMAT);
        $o->end = $this->end->format(self::MYSQL_DATE_TIME_FORMAT);
        $o->estado = $this->estado;
        $o->nombre = $this->nombre;
        return $o;
    }
 

    /**
     * Actualiza este Cita a partir de un diccionario PHP. No todas las propiedades tienen que actualizarse.
     * Por ejemplo el array("title" => "Nueva descripcion", "end" => "2019-04-30 00:00:00") sólo actualiza las 
     * propiedades "title" y "end".
     *
     * @param array $diccionario Array / map / diccionario PHP con los datos del Cita a actualizar.
     * @param array[string] $propiedadesAIgnorar Nombre de propiedades que se ignorarán, y no se actualizarán, si se
     *                                           encuentran en $diccionario.
     *
     */
    public function actualizaDesdeDiccionario(array $diccionario, array $propiedadesAIgnorar = [])
    {
        $propiedadesAIgnorar[] = 'id';

        foreach($propiedadesAIgnorar as $prop) {
            if( isset($diccionario[$prop]) ) {
                unset($diccionario[$prop]);
            }
        }
        
        return $this->asignaDesdeDiccionario($diccionario);
    }
    
    /**
     * Actualiza este Cita a partir de un diccionario PHP. No todas las propiedades tienen que actualizarse, aunque son
     * obligatorias las propiedades cuyo nombre se incluyan en $propiedadesRequeridas.
     *
     * @param array $diccionario Array / map / diccionario PHP con los datos del Cita a actualizar.
     * @param array[string] $propiedadesRequeridas Nombre de propiedades que se requieren actualizar. Si no existen en
     *                                             $diccionario, se lanza BadMethodCallException.
     *
     */
    protected function asignaDesdeDiccionario(array $diccionario, array $propiedadesRequeridas = [])
    {
        foreach($diccionario as $key => $val) {
            if (!in_array($key, self::PROPERTIES)) {
                throw new \BadMethodCallException('Propiedad no esperada en $diccionario: '.$key);
            }
        }

        foreach($propiedadesRequeridas as $prop) {
            if( ! isset($diccionario[$prop]) ) {
                throw new \BadMethodCallException('El array $diccionario debe tener las propiedades: '.implode(',', $propiedadesRequeridas));
            }
        }

        if (array_key_exists('id', $diccionario)) {
            $id = $diccionario['id'];
            if (empty($id)) {
                throw new \BadMethodCallException('$diccionario[\'id\'] no puede ser una cadena vacía o nulo');
            } else if (! ctype_digit($id)) {
                throw new \BadMethodCallException('$diccionario[\'id\'] tiene que ser un número entero');
            } else {
                $this->id =(int)$id;
            }
        }

        if (array_key_exists('id_cliente', $diccionario)) {
            $id_cliente = $diccionario['id_cliente'];
            if (empty($id_cliente)) {
                throw new \BadMethodCallException('$diccionario[\'id_cliente\'] no puede ser una cadena vacía o nulo');
            } else if (!is_int($id_cliente) && ! ctype_digit($id_cliente)) {
                throw new \BadMethodCallException('$diccionario[\'id_cliente\'] tiene que ser un número entero: '.$id_cliente);
            } else {
                $this->setid_cliente((int)$id_cliente);
            }
        }

        if (array_key_exists('id_mecanico', $diccionario)) {
            $id_mecanico = $diccionario['id_mecanico'];
                if (empty($id_mecanico)) {
                    throw new \BadMethodCallException('$diccionario[\'id_mecanico\'] no puede ser una cadena vacía o nulo');
                } else if (!is_int($id_mecanico) && ! ctype_digit($id_mecanico)) {
                    throw new \BadMethodCallException('$diccionario[\'id_mecanico\'] tiene que ser un número entero: '.$id_mecanico);
                } else {
                    $this->setid_mecanico((int)$id_mecanico);
                }
        }
       

        if (array_key_exists('title', $diccionario)) {
            $title = $diccionario['title'];
            if (is_null($title)) {
                throw new \BadMethodCallException('$diccionario[\'title\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->setTitle($title);
            }
        }

        
        if (array_key_exists('start', $diccionario)) {
            $start = $diccionario['start'];
            if (empty($start)) {
                throw new \BadMethodCallException('$diccionario[\'start\'] no puede ser una cadena vacía o nulo');
            } else {
                $startDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $start);
                if (!$startDate) {
                    throw new \BadMethodCallException('$diccionario[\'start\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
                }
                $this->start = $startDate;
            }
        }

        
        if (array_key_exists('end', $diccionario)) {
            $end = $diccionario['end'] ?? null;
            if (empty($end)) {
                throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $endDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $end);
                if (!$endDate) {
                    throw new \BadMethodCallException('$diccionario[\'end\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
                }
                $this->end = $endDate;
            }
        }
        if (array_key_exists('estado', $diccionario)){
            $estado = $diccionario['estado'] ?? null;
            $this->estado = $estado;

        }

        if(array_key_exists('nombre', $diccionario)){
            $nombre = $diccionario['nombre'] ?? null;
            $this->nombre = $nombre;
        }
        
        self::compruebaConsistenciaFechas($this->start, $this->end);
        
        return $this;
    }
}
