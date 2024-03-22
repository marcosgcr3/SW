<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/citas.php';
use es\ucm\fdi\aw\citas\Citas;

$contenido = '';

function listaCitas(){
    $citas = Citas::listaCitas();
    $contenido = '';
    if(empty($citas)){
        return sinCitas();
    }
    
    foreach ($citas as $cita){
        $contenido .= misCitas($cita);
    }
    $contenido .= <<<EOS
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}
function listaCitasMecanico($id){
    $citas = Citas::listaCitasM($id);
    $contenido = '';
    if(empty($citas)){
        return sinCitas();
    }
    
    foreach ($citas as $cita){
        $contenido .= misCitas($cita);
    }
    $contenido .= <<<EOS
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}
function listaCitasMecanicoDias($id){
    $dias = Citas::diasConCitas($id);
    $contenido = '';
    foreach ($dias as $dia){
        $contenido .= "<h2>$dia</h2>";
        $citas = Citas::listaCitasMecanicoEnUnDia($id, $dia);
        foreach ($citas as $cita){
            $contenido .= misCitas($cita);
        }
       
    }
    return $contenido;

}
function mostrarCalendarioCitas($idMecanico) {
    // Obtener los días de la semana y las citas del mecánico
    $dias = Citas::diasConCitas($idMecanico);
    $citasPorDia = [];
    foreach ($dias as $dia) {
        $citasPorDia[$dia] = Citas::listaCitasMecanicoEnUnDia($idMecanico, $dia);
    }

    // Crear la estructura HTML del calendario
    $html = '<table>';
    $html .= '<thead><tr><th>Hora</th>';
    foreach ($dias as $dia) {
        // Obtener el nombre del día de la semana
        $nombreDia = strftime('%A', strtotime($dia));
        $html .= "<th>$nombreDia</th>";
    }
    $html .= '</tr></thead>';
    $html .= '<tbody>';

    // Definir las horas del día
    $horasDia = range(9, 17);

    // Iterar sobre cada hora del día
    foreach ($horasDia as $hora) {
        // Formatear la hora con cero inicial si es menor de 10
        $horaFormateada = sprintf('%02d:00', $hora);
        $html .= '<tr>';
        $html .= "<td>$horaFormateada</td>";

        // Iterar sobre cada día y mostrar la cita correspondiente
        foreach ($dias as $dia) {
            $html .= '<td>';
            $citaEnHora = null;
            foreach ($citasPorDia[$dia] as $cita) {
                if ($cita->getHora() == $hora) {
                    $citaEnHora = $cita;
                    break;
                }
            }
            if ($citaEnHora) {
                $html .= $citaEnHora->getAsunto();
            } else {
                $html .= '-';
            }
            $html .= '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    return $html;
}

function misCitas($cita){
   $contenido = buildCita($cita);
   return $contenido;
}
function misCitasH($cita){
    $contenido = buildCitaH($cita);
    return $contenido;
 }
function sinCitas(){
    $contenido = <<<EOS
    <h2>No tienes citas</h2>
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}

function newCita(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}
