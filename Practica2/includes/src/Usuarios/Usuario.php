<?php

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
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM Usuarios WHERE NIF=$NIF";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorCorreo($correo)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM Usuarios WHERE correo='$correo'";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorId($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios WHERE id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['id'],$fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol']);
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
    public function getNombre()
    {
        return $this->nombre;
    }
    public function guarda()
    {
        if ($this->id != null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuarios U SET NIF = '%s', nombre='%s', password='%s' WHERE U.NIF=%d"
            , $conn->real_escape_string($usuario->NIF)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $usuario->NIF
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
   

    private static function inserta($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuarios(NIF, nombre, apellido, correo, password, rol)
        VALUES ('$usuario->NIF', '$usuario->nombre', '$usuario->apellido', '$usuario->correo', '$usuario->password', '$usuario->rol')");
        
        if ( $conn->query($query) ) {
           
            $result = $usuario;
        } else {
            
            file_put_contents("falloBD.txt",$query);
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
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
    public function getNombreUsuario()
    {
        return $this->nombre;
    }
    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

}