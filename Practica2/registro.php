<?php
session_start();
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
    <div class="container-registro">
        <h2>Registro de Usuario</h2>

        <form action="ProcesaRegistro.php" method="post">
            <p>Nombre:</p>
            <input type="text" name="nombre" id="nombre"required>
            <p>Apellido:</p>
            <input type="text" name="apellidos" id="apellidos" required>
            <p>Correo:</p>
            <input type="email" name="correo" id="correo" required>
            <p>Usuario:</p>
            <input type="text" name="usuario" id="usuario" required>
            <p>NIF:</p>
            <input type="text" name="NIF" id="NIF" required>
            <p>Contraseña(minimo 6 caracteres, 1 mayuscula, 1 minuscula y un numero):</p>
            
            <input type="password" name="password" id="password" required>
            <p>Confirmar contraseña:</p>
            <input type="password" name="password2" id="password2" required>
            <p></p>
            <input type="submit" value="Registrarse">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
    </footer>

    <script src="js/cabecera.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
        

