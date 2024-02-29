<?php

class Usuario
{

    

    public const ADMIN_ROLE = 'admin';

    public const USER_ROLE = 'user';

    public const MECANICO_ROLE = 'mecanico';
    
    public static function login($NIF, $password)
    {
        $conn = BD::getInstance()->getConexionBd();
        $sql = "SELECT * FROM usuarios WHERE NIF = '$NIF' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION["login"] = true;
             $sql = "SELECT rol FROM usuarios WHERE NIF = '$NIF'";
    
            $tipoResult = $conn->query($sql);
            $tipo = $tipoResult->fetch_assoc()["rol"];
        
            
            if ($tipo == "admin") {
                $_SESSION["tipo"]= "admin";
                $_SESSION["esAdmin"] = true;
                $_SESSION["esMecanico"] = NULL;
            } else if ($tipo == "mecanico") {
                $_SESSION["tipo"]= "mecanico";
                $_SESSION["esMecanico"] = true;
                $_SESSION["esAdmin"] = NULL;
            } else {
                $_SESSION["esAdmin"] = NULL;
                $_SESSION["esMecanico"] = NULL;
                
            }
           return true;
        }
       
        return false;
    }
    
    public static function crea($NIF, $nombre,$apellido, $correo ,$password,$rol, $id_taller)
    {
        $user = new Usuario($NIF, $nombre,$apellido, $correo ,self::hashPassword($password),$rol, $id_taller);
        
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
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol'], $fila['id_taller']);
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

    private $id_taller;
    private function __construct($NIF, $nombre,$apellido,$correo, $password, $rol ,$id_taller)
    {
        $this->NIF = $NIF;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->password = $password;
        $this->rol = $rol;
        $this->id_taller = $id_taller;
        
    }
    public function getNombre()
    {
        return $this->nombre;
    }
}