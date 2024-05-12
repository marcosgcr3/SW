<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\citas\cita;
use es\ucm\fdi\aw\usuarios\Usuario;

// Procesamos la cabecera Content-Type
$contentType= $_SERVER['CONTENT_TYPE'] ?? 'application/json';
$contentType = strtolower(str_replace(' ', '', $contentType));

// Verificamos corresponde con uno de los tipos soportados
$acceptedContentTypes = array('application/json;charset=utf-8', 'application/json');
$found = false;
foreach ($acceptedContentTypes as $acceptedContentType) {
    if (substr($contentType, 0, strlen($acceptedContentType)) === $acceptedContentType) {
        $found=true;
        break;
    }
}

if (!$found) {
    http_response_code(400);
    echo 'Este servicio REST sólo soporta el content-type application/json';
    die();
}

$result = null;

/**
 * Las API REST usan la semántica de los métoods HTTP para gestionar las diferentes peticiones:
 * https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_methods
 */

 switch($_SERVER['REQUEST_METHOD']) {
    // Consulta de datos
    case 'GET':
        try {
            // Comprobamos si es una consulta de un Cita concreto -> Citas.php?idCita=XXXXX
            $idCita = filter_input(INPUT_GET, 'idCita', FILTER_VALIDATE_INT);
            if ($idCita) {
                $result = [];
                    $result[] = Cita::buscaPorId((int)$idCita);
            } else {
                // Comprobamos si es una lista de Citas entre dos fechas -> Citas.php?start=XXXXX&end=YYYYY
                // https://fullcalendar.io/docs/events-json-feed
                $start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_SPECIAL_CHARS);
                $end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_SPECIAL_CHARS);
                if ($start) {
                    $startDateTime = \DateTime::createFromFormat(DateTime::ISO8601, $start);
                    $endDateTime = \DateTime::createFromFormat(DateTime::ISO8601, $end);
                    
                    
                        $result = Cita::misCitas($_SESSION['id'], $startDateTime, $endDateTime);

                } else {
                    http_response_code(400);
                    echo 'Parámetros start o end incorrectos';
                    die();
                }
            }
            

            // Generamos un array de Citas en formato JSON
            $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

            http_response_code(200); // 200 OK
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Length: ' . mb_strlen($json));

            echo $json;
        }catch(Exception $e) {
            http_response_code(500);
            echo 'Error en la aplicación';
            error_log($e);
            die();
        }

    break;
    case 'POST':
        if(!$app->esMecanico() && $app->usuarioLogueado()){
        // 1. Leemos el contenido que nos envían
        $entityBody = file_get_contents('php://input');
        // 2. Verificamos que nos envían un objeto
        $dictionary = json_decode($entityBody);
        if (!is_object($dictionary)) {
            throw new ParametroNoValidoException('El cuerpo de la petición no es valido');
        }
        
        // 3. Reprocesamos el cuerpo de la petición como un array PHP
        $fecha = $dictionary->start;
        $mecanicoDisp = Usuario::obtenerMecanicoDisponible($fecha);
        $dictionary = json_decode($entityBody, true);
        $dictionary['id_mecanico'] = $mecanicoDisp;// HACK: normalmente debería de ser App::getSingleton()->idUsuario();
        $dictionary['id_cliente'] = $_SESSION['id'];
        $dictionary['estado'] = 1;
        $e = Cita::creaDesdeDicionario($dictionary);
        
        // 4. Guardamos el Cita en BD
        $result = Cita::guardaOActualiza($e);
        
        // 5. Generamos un objecto como salida.
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

        http_response_code(201); // 201 Created
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . mb_strlen($json));

        echo $json;  
    } 

    break;
    case 'PUT':

            // 1. Comprobamos si es una consulta de un Cita concreto -> Citas.php?idCita=XXXXX
            $idCita = filter_input(INPUT_GET, 'idCita', FILTER_VALIDATE_INT);
            // 2. Leemos el contenido que nos envían
            $entityBody = file_get_contents('php://input');
            // 3. Verificamos que nos envían un objeto
            $dictionary = json_decode($entityBody);
            if (!is_object($dictionary)) {
                throw new ParametroNoValidoException('El cuerpo de la petición no es valido');
            }    

            // 4. Reprocesamos el cuerpo de la petición como un array PHP
            $dictionary = json_decode($entityBody, true);
            $e = Cita::buscaPorId($idCita);
            $e->actualizaDesdeDiccionario($dictionary, ['id', 'id_cliente', 'id_mecanico']);
            $result = Cita::guardaOActualiza($e);
            
            // 5. Generamos un objecto como salida.
            $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
            
            http_response_code(200); // 200 OK
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Length: ' . mb_strlen($json));

            echo $json; 

  
        break;
    case 'DELETE':
        
        // 1. Comprobamos si es una consulta de un Cita concreto -> Citas.php?idCita=XXXXX
        $idCita = filter_input(INPUT_GET, 'idCita', FILTER_VALIDATE_INT);
        // 2. Borramos el Cita
        Cita::borraPorId($idCita);

        http_response_code(204); // 204 No content (como resultado)
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: 0');
        break;
        
    default:
        throw new MetodoNoSoportadoException($_SERVER['REQUEST_METHOD']. ' no está soportado');
    break;

    ;
}
