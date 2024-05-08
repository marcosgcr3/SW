<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;

function buildVehiculo($vehiculo)
{
    $contenido = '';
    $archivado = $vehiculo->getArchivado();
    $matricula = $vehiculo->getMatricula();
    $marca = $vehiculo->getMarca();
    $modelo = $vehiculo->getModelo();
    $precio = $vehiculo->getPrecio();
    $year = $vehiculo->getYear();
    $imagen = $vehiculo->getImagen();

    $contenido .= <<<EOS
    <div class="producto">
        <div class="producto-info">
            <img src="$imagen" alt="imagen" class="producto-imagen">
            <div class="producto-detalle">
                <h2>$marca : $modelo ($year)</h2>
                <p>$matricula</p>
                <p>Precio: $precio&euro;</p>
                <p>Archivado: $archivado</p>               
            
    EOS;
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        $contenido .= <<<EOS
            </div>
            <form id="formBorrarVehiculo_$matricula" action="borrarVehiculo.php" method="post">
                <input type="hidden" name="matricula" value="$matricula">
            </form>
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarVehiculo_$matricula').submit();"></i>
            <form id="formEditarVehiculo_$matricula" action="editarVehiculo.php" method="post">
                <input type="hidden" name="matricula" value="$matricula">
            </form>
            <i id="iconoEditar" onclick="document.getElementById('formEditarVehiculo_$matricula').submit();">Editar</i>

            
            <form action="archivarVehiculo.php" method="post">
                <input type="hidden" name="matricula" value="$matricula">
                <button class="iconoArchivar" type="submit">ARCHIVAR</button>
            </form>
            


        </div></div>
        EOS;
    } else {
        $contenido .= <<<EOS
            
            <form action="alquilarVehiculo.php" method="post">
                <input type="hidden" name="matricula" value="$matricula">
                <button class="botoncarro" type="submit">Alquilar</button>
            </form>
        </div></div></div>
        EOS;
    }

    return $contenido;
}