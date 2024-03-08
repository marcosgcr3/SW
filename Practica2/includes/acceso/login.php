<?php

function buildFormularioLogin($NIF='', $password='')
{
    return <<<EOS
    <div class="container-registro">
        <h2>Login Usuario</h2>

        <form action="ProcesaLogin.php" method="post">
            
            <p>NIF:</p>
            <input type="text" name="NIF" id="NIF" value="$NIF" required>
            <p>Contraseña:</p>
            
            <input type="password" name="password" id="password" password="$password" required>
            <p></p>
            <input type="submit" value="Entrar">
        </form>
    </div>
    EOS;
}