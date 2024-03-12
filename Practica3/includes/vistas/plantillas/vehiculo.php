<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;

function buildVehiculo($matricula, $marca, $modelo, $precio, $year, $imagen)
{
    $contenido = <<<EOS
    <div class="producto">
        <div class="producto-info">
            <img src="$imagen" alt="imagen" class="producto-imagen">
            <div class="producto-detalle">
                <h2>$marca : $modelo ($year)</h2>
                <p>$matricula</p>
                <p>Precio: $precio&euro;</p>
               
                
            
    EOS;
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        $contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        //$contenido .= '<button class="botoncarro">Añadir al carrito</button></div></div></div>';
        $contenido .= '<button class="botoncarro" onclick="location.href=\'alquilarVehiculo.php?matricula=' . $matricula . '&id_usuario=' . $_SESSION['id'] . '\';">Alquilar</button></div></div></div>';
    }

    return $contenido;
}