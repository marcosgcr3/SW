<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\vehiculos\vehiculo;

function buildAlquilerPendiente($alquiler){
    $id = $alquiler->getId();
    $id_vehiculo = $alquiler->getIdVehiculo();
    $fechaIni = $alquiler->getFechaIni();
    $fechaFin = $alquiler->getFechaFin();
    $precio = $alquiler->getPrecioFinal();
    
    
    $vehiculo = Vehiculo::buscaPorId($id_vehiculo);
    $imagen = $vehiculo->getImagen();
    $marca = $vehiculo->getMarca();
    $modelo = $vehiculo->getModelo();
    $matricula = $vehiculo->getMatricula();
    $contenido="";
    $contenido.=<<<EOS
    <div class="producto">
    
        <div class="producto-info">
        
        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
        <h2>$marca:  $modelo</h2>
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
       
    
EOS;    
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        //$contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        $contenido .= <<<EOS
            
        <form action="devolverVehiculo.php" method="post">
            <input type="hidden" name="id" value="$id">
            <button class="botoncarro" type="submit">Devolver</button>
        </form>

        <form action="alquilarVehiculo.php" method="post">
            <input type="hidden" name="matricula" value="$matricula">
            <button class="botoncarro" type="submit">Ampliar</button>
         </form>
    </div></div></div>
    EOS;
    }

    return $contenido;
}
function buildAlquiler($alquiler)
{
    $id = $alquiler->getId();
    $id_vehiculo = $alquiler->getIdVehiculo();
    $fechaIni = $alquiler->getFechaIni();
    $fechaFin = $alquiler->getFechaFin();
    $precio = $alquiler->getPrecioFinal();
    
    
    $vehiculo = Vehiculo::buscaPorId($id_vehiculo);
    $imagen = $vehiculo->getImagen();
    $marca = $vehiculo->getMarca();
    $modelo = $vehiculo->getModelo();
    $contenido="";
    $contenido.=<<<EOS
    <div class="producto">
    
        <div class="producto-info">
        
        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
        <h2>$marca:  $modelo</h2>
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
       
    
EOS;    
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        //$contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        
        $contenido .= <<<EOS
            </div>
            <form id="formBorrarAlquiler_$id" action="eliminarAlquiler.php" method="post">
                <input type="hidden" name="id_alquiler" value="$id">
            </form>
            <i id="iconoBasura" onclick="confirmarBorrado($id)">Cancelar</i>
            <i id="iconoModificar" type"submit">Modificar</i>

            </div></div>
            <script>
                function confirmarBorrado(id) {
                    if (confirm("¿Seguro que desea eliminar este alquiler?")) {
                        document.getElementById('formBorrarAlquiler_' + id).submit();
                        alert("Se ha elimiando con éxito");
                    }
                }
            </script>
            EOS;
    }

    return $contenido;
}

function buildHistorialAlquiler($alquiler)
{
    $id = $alquiler->getId();
    $id_vehiculo = $alquiler->getIdVehiculo();
    $fechaIni = $alquiler->getFechaIni();
    $fechaFin = $alquiler->getFechaFin();
    $precio = $alquiler->getPrecioFinal();
    
    
    $vehiculo = Vehiculo::buscaPorId($id_vehiculo);
    $imagen = $vehiculo->getImagen();
    $marca = $vehiculo->getMarca();
    $modelo = $vehiculo->getModelo();
    $contenido="";
    $contenido.=<<<EOS
    <div class="producto">
    
        <div class="producto-info">
        
        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
        <h2>$marca:  $modelo</h2>
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
        </div></div></div>
    
    EOS;    

    return $contenido;
}
