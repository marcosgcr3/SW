<<<<<<< HEAD
<?php
session_start();
$NIF = htmlspecialchars(trim(strip_tags($_REQUEST["NIF"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));

$conn=mysqli_connect("localhost", "root", "", "DriveCrafters");
$sql = "SELECT * FROM usuarios WHERE NIF = '$NIF' AND password = '$password'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $_SESSION["login"] = true;
    $sql = "SELECT nombre FROM usuarios WHERE NIF = '$NIF'";
    $nombreResult = $conn->query($sql);
    $nombre = $nombreResult->fetch_assoc()["nombre"];
    $_SESSION["nombre"] = $nombre;
    $sql = "SELECT tipo_user FROM usuarios WHERE NIF = '$NIF'";
    
    $tipoResult = $conn->query($sql);
    $tipo = $tipoResult->fetch_assoc()["tipo_user"];

    
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



} else {
    $_SESSION["login"] = NULL;
    echo "Usuario o contraseña incorrectos";
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link id="estilo" rel="stylesheet" href="css/index.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Index" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
    <title>DriveCrafters</title>
</head>

<body> 

    <div class="container-encabezado">
        <?php include("componentes/header.php"); ?> 

    </div> 
        <?php
        if (!isset($_SESSION["login"])) { 
            echo "<h1>ERROR</h1>";
            echo "<p>El usuario o contraseña no son válidos.</p>";
        } else { 
            echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
            echo "<p>Es un usuario registrado</p>";
        }
        ?>
    
   
    <footer>
        <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
    </footer>

    <script src="js/cabecera.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
=======
<?php
session_start();
$NIF = htmlspecialchars(trim(strip_tags($_REQUEST["NIF"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));

$conn=mysqli_connect("localhost", "root", "", "DriveCrafters");
$sql = "SELECT * FROM usuarios WHERE NIF = '$NIF' AND password = '$password'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $_SESSION["login"] = true;
    $sql = "SELECT nombre FROM usuarios WHERE NIF = '$NIF'";
    $nombreResult = $conn->query($sql);
    $nombre = $nombreResult->fetch_assoc()["nombre"];
    $_SESSION["nombre"] = $nombre;
    $sql = "SELECT tipo_user FROM usuarios WHERE NIF = '$NIF'";
    
    $tipoResult = $conn->query($sql);
    $tipo = $tipoResult->fetch_assoc()["tipo_user"];

    
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



} else {
    $_SESSION["login"] = NULL;
    echo "Usuario o contraseña incorrectos";
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link id="estilo" rel="stylesheet" href="css/index.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Index" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
    <title>DriveCrafters</title>
</head>

<body> 

    <div class="container-encabezado">
        <?php include("componentes/header.php"); ?> 

    </div> 
        <?php
        if (!isset($_SESSION["login"])) { 
            echo "<h1>ERROR</h1>";
            echo "<p>El usuario o contraseña no son válidos.</p>";
        } else { 
            echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
            echo "<p>Es un usuario registrado</p>";
        }
        ?>
    
   
    <footer>
        <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
    </footer>

    <script src="js/cabecera.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
>>>>>>> c3d2392ea84a67af5b94d706eb9fe1d48bf813d7
        