<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Usuario
{
    use MagicProperties;

    
    public static function login($NIF, $password)
    {
        $usuario = self::buscaPorNIF($NIF);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function crea($NIF, $nombre,$apellido, $correo ,$password)
    {
        $user = new Usuario($NIF, $nombre,$apellido, $correo ,self::hashPassword($password),"usuario");
        
        return $user->guarda();
    }

    public static function buscaPorNIF($NIF)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM usuarios WHERE NIF='$NIF'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorCorreo($correo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM usuarios WHERE correo='$correo'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol'],$fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

   
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuarios(NIF, nombre, apellido, correo, password, rol)
        VALUES ('$usuario->NIF', '$usuario->nombre', '$usuario->apellido', '$usuario->correo', '$usuario->password', '$usuario->rol')");
        
        if ( $conn->query($query) ) {
           
            $result = $usuario;
        } else {
            
            file_put_contents("falloBD.txt",$query);
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    
    
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE usuarios U SET NIF = '%s', nombre='%s', password='%s' WHERE U.NIF=%d"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $usuario->id
        );
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha actualizado el usuario");
            }
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function borraRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario RU WHERE RU.usuario = %d"
            , $usuario->id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM usuarios U WHERE U.id = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }
    

    public static function listaMecanicos(){
        $lista_mecanicos = array();
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM usuarios WHERE rol='mecanico'";
        $rs = $conn->query($query);
        
        if ($rs) {
            while($fila = $rs->fetch_assoc()){
                $mecanico = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol'],$fila['id']);
                array_push($lista_mecanicos, $mecanico);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $lista_mecanicos;

    }
    public static function obtenerMecanicoDisponible($fecha, $hora)
    {
    
        // Obtener todos los mecánicos
        $mecanicos = self::listaMecanicos();
        $mecanicoDisponible = null;
        $citasMenosCitas = PHP_INT_MAX;
    
        foreach ($mecanicos as $mecanico) {
            if (self::estaDisponible($mecanico, $hora, $fecha)) {
                $numCitas = self::numCitasTotales($mecanico);
                if ($numCitas < $citasMenosCitas) {
                    $citasMenosCitas = $numCitas;
                    $mecanicoDisponible = $mecanico;
                }
            }
        }
    
        return $mecanicoDisponible;
    }
    // Función para verificar si un mecánico está disponible en una hora y día específicos
// Función para verificar si un mecánico está disponible en una hora y día específicos
// Función para verificar si un mecánico está disponible en una hora y día específicos
private static function estaDisponible($mecanico, $hora, $dia) {
    $conn = Aplicacion::getInstance()->getConexionBd();
    $idMecanico = $mecanico->getId();

    // Formatear la fecha y hora para compararla con las citas del mecánico
    $fechaHora = $dia . ' ' . $hora;

    // Consultar si hay citas para el mecánico en la hora y día dados
    $query = "SELECT COUNT(*) AS numCitas FROM citas WHERE id_mecanico = $idMecanico AND startDate = '$fechaHora' AND estado = 0";
    $rs = $conn->query($query);

    if ($rs) {
        $fila = $rs->fetch_assoc();
        $numCitas = $fila['numCitas'];
        $rs->free();

        // Si el número de citas es 0, el mecánico está disponible
        return $numCitas == 0;
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
        return false;
    }
}

// Función para contar el número total de citas de un mecánico
private static function numCitasTotales($mecanico) {
    $conn = Aplicacion::getInstance()->getConexionBd();
    $idMecanico = $mecanico->getId();

    // Consultar el número total de citas para el mecánico
    $query = "SELECT COUNT(*) AS numCitas FROM citas WHERE id_mecanico = $idMecanico";
    $rs = $conn->query($query);

    if ($rs) {
        $fila = $rs->fetch_assoc();
        $numCitas = $fila['numCitas'];
        $rs->free();

        return $numCitas;
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
        return 0;
    }
}

    private $NIF;

    private $nombre;

    private $password;

    private $apellido;

    private $rol;

    private $correo;

    private $id;
    private function __construct($NIF, $nombre,$apellido,$correo, $password, $rol , $id = null)
    {
        $this->id = $id;
        $this->NIF = $NIF;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->password = $password;
        $this->rol = $rol;

        
    }
    public function getId()
    {
        return $this->id;
    }

    public function getNIF()
    {
        return $this->NIF;
    }
    public function getRol()
    {
        return $this->rol;
    }
    public function getCorreo()
    {
        return $this->correo;
    }

    
    public function getApellido()
    {
        return $this->apellido;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
