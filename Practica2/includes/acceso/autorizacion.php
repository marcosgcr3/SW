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
    return estaLogado() && (array_search(Usuario::ADMIN_ROLE, $_SESSION['rol']) !== false);
}

function verificaLogado($urlNoLogado)
{
    if (! estaLogado()) {
        Utils::redirige($urlNoLogado);
    }
}