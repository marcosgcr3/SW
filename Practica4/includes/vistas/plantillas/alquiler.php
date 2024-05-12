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
    <div class="alquiler">
    
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
        <form action="devolverVehiculo.php" method="post">
            <input type="hidden" name="id" value="$id">
            <button class="botonD" type="submit">Devolver</button>
        </form>
        <script>
                function confirmarBorrado(id) {
                    if (confirm("¿Seguro que desea devolver este alquiler?")) {
                        document.getElementById('formBorrarAlquiler_' + id).submit();
                        alert("Se ha devuelto con éxito");
                    }
                }
            </script>

        </div></div>
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
    <div class="alquiler">
    
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
            <div class="archivar">
            <form id="formBorrarAlquiler_$id" action="eliminarAlquiler.php" method="post">
                <input type="hidden" name="id_alquiler" value="$id">
            </form>
            <button class="botonA" onclick="confirmarBorrado($id)">Cancelar</i>
            </div>

            </div></div>
            <script>
                function confirmarBorrado(id) {
                    if (confirm("¿Seguro que desea cancelar este alquiler?")) {
                        document.getElementById('formBorrarAlquiler_' + id).submit();
                        alert("Se ha cancelado con éxito");
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
    <div class="alquiler">
    
        <div class="producto-info">

        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
        <h2>$marca:  $modelo</h2>
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
            <p>Estado: FINALIZADO</p>
        </div></div></div>

        
    
    EOS;    

    return $contenido;
}

function buildHistorialCancelados($alquiler)
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
    <div class="alquiler">
    
        <div class="producto-info">

        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
        <h2>$marca:  $modelo</h2>
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
            <p>Estado: CANCELADO</p>
        </div></div></div>

        
    
    EOS;    

    return $contenido;
}
