<?php

function buildFormularioRegistro($nombre='', $apellido='', $correo='', $NIF='', $password='' )
{
    return <<<EOS
    <div class="container-registro">
        <h2>Registro de Usuario</h2>

        <form action="ProcesaRegistro.php" method="post">
            
            <input type="text" name="nombre" id="nombre"required autocomplete="off" placeholder="Nombre" value="$nombre">
            
            <input type="text" name="apellidos" id="apellidos" required autocomplete="off" placeholder="Apellido" value = "$apellido">
            
            <input type="email" name="correo" id="correo" required autocomplete="off" placeholder="Correo"  value = "$correo">
            
            <input type="text" name="NIF" id="NIF" required autocomplete="off" placeholder ="NIF" value = "$NIF">
            
           
            <input type="password" name="password" id="password" required autocomplete="off" placeholder ="password" password = "$password">
            <p>Confirmar contraseña:</p>
            <input type="password" name="password2" id="password2" required autocomplete="off" placeholder ="password repite" password = "$password">
            <p></p>
            <input type="submit" value="Registrarse">
        </form>
    </div>
    EOS;
}