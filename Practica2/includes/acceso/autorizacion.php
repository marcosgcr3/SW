<?php

function estaLogado()
{
    return isset($_SESSION['NIF']);
}


function esMismoUsuario($NIF)
{
    return estaLogado() && $_SESSION['NIF'] == $NIF;
}

function idUsuarioLogado()
{
    return $_SESSION['NIF'] ?? false;
}

function esAdmin()
{
    return estaLogado() && ($_SESSION['rol'] == "admin");
}
function esMecanico()
{
    return estaLogado() && ($_SESSION['rol'] == "mecanico");
}

function verificaLogado($urlNoLogado)
{
    if (! estaLogado()) {
        Utils::redirige($urlNoLogado);
    }
}