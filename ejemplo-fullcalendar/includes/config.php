<?php
// Varios defines para los parámetros de configuración de acceso a la BD y la URL desde la que se sirve la aplicación
define('BD_HOST', 'localhost');
define('BD_NAME', 'aw');
define('BD_USER', 'aw');
define('BD_PASS', 'aw');
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/ejemplo-fullcalendar/');
define('RUTA_IMGS', RUTA_APP.'img/');
define('RUTA_CSS', RUTA_APP.'css/');
define('RUTA_JS', RUTA_APP.'js/');
define('INSTALADA', true);
define('DEBUG', true);

if (! INSTALADA) {
  echo "La aplicación no está configurada";
  exit();
}

/* */
/* Configuración del charset */
/* */

/* Enlaces de interés para el soporte de UTF-8:
 * https://www.toptal.com/php/a-utf-8-primer-for-php-and-mysql
 * https://allseeing-i.com/how-to-setup-your-php-site-to-use-utf8
 * http://www.instantshift.com/2014/10/29/mbstring-and-php/
 * https://stackoverflow.com/questions/6987929/preparing-php-application-to-use-with-utf-8
 * 
 * Una vez configurado hay que asegurarse de especificar la codificación 'UTF-8' en las funciones 
 * que tengan un parámetro charset (en PHP >= 5.6 suelen tomar el valor 'UTF-8' por defecto, 
 * pero en versiones anteriores no) y utilizar las funciones http://php.net/manual/en/book.mbstring.php.
 */

/*
 * Configuración de la codificación de la aplicación
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');

// Configuración de la zona horaria por defecto
date_default_timezone_set('Europe/Madrid');

/**
 * Función para autocargar clases PHP.
 *
 * @see http://www.php-fig.org/psr/psr-4/
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'es\\ucm\\fdi\\aw\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

/* */
/* Inicialización del objeto aplicacion */
/* */
$app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS), RUTA_APP, RAIZ_APP);

/**
 * Parse, sort and select best content type, supported by a user browser.
 *
 * @param string $acceptRules Supported types in the HTTP Accept header format (e.g. $_SERVER['HTTP_ACCEPT'])
 * @param string|string[] $supported An associative array of supported MIME types.
 * @param string $default The default type to use if none match
 *
 * @return string Matched by $supported type or all accepted types.
 *
 * @link Inspired by http://stackoverflow.com/a/1087498/3155344
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Content_negotiation
 */
function resolveContentNegotiation(string $acceptRules, array $supported, string $default = null)
{

    // Accept header is case insensitive, and whitespace isn't important.
    $acceptRules = strtolower(str_replace(' ', '', $acceptRules));

    $sortedAcceptTypes = array();
    foreach (explode(',', $acceptRules) as $acceptRule) {
        $q = 1; // the default accept quality (rating).

        // Check if there is a different quality.
        if (strpos($acceptRule, ';q=') !== false) {
        // Divide "type;q=X" into two parts: "type" and "X"
            list($acceptRule, $q) = explode(';q=', $acceptRule, 2);
        }
        $sortedAcceptTypes[$acceptRule] = $q;
    }
    // WARNING: zero quality is means, that type isn't supported! Thus remove them.
    $sortedAcceptTypes = array_filter($sortedAcceptTypes);
    arsort($sortedAcceptTypes, SORT_NUMERIC);

    // If no parameter was passed, just return parsed data.
    if (!$supported) {
        return $sortedAcceptTypes;
    }

    $supported = array_map('strtolower', $supported);

    // Let's check our supported types.
    foreach ($sortedAcceptTypes as $type => $q) {
        foreach ($supported as $desired) {
            if ($q && fnmatch($desired, $type)) {
                return $type;
            }
        }
    }

    // No matched type.
    return $default;
}

/**
* jTraceEx() - provide a Java style exception trace
* @param $exception
* @param $seen      - array passed to recursive calls to accumulate trace lines already seen
*                     leave as NULL when calling this function
* @return array of strings, one entry per trace line
*
* @see https://www.php.net/manual/en/exception.gettraceasstring.php#114980
*/
function jTraceEx($e, $seen=null) {
    $starter = $seen ? 'Caused by: ' : '';
    $result = array();
    if (!$seen) $seen = array();
    $trace  = $e->getTrace();
    $prev   = $e->getPrevious();
    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
    $file = $e->getFile();
    $line = $e->getLine();
    while (true) {
        $current = "$file:$line";
        if (is_array($seen) && in_array($current, $seen)) {
            $result[] = sprintf(' ... %d more', count($trace)+1);
            break;
        }
        $result[] = sprintf(' at %s%s%s(%s%s%s)',
                                    count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
                                    count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
                                    count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
                                    $line === null ? $file : basename($file),
                                    $line === null ? '' : ':',
                                    $line === null ? '' : $line);
        if (is_array($seen))
            $seen[] = "$file:$line";
        if (!count($trace))
            break;
        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
        array_shift($trace);
    }
    $result = join("\n", $result);
    if ($prev)
        $result  .= "\n" . jTraceEx($prev, $seen);

    return $result;
}

/**
 * Gestor de excepciones de toda la aplicación.
 *
 * Cuando tu código (o el propio PHP) lanza una excepción (o genera un error) la excepción resultante es capturada /
 * gestionada por el siguiente código.
 *
 * El objetivo de este código es generar una salida adecuada para el error dependiendo de si el error va a ser procesado
 * desde javascript (a través de AJAX) o si la va a ver directamente el usuario final.
 */
set_exception_handler(function (\Throwable $e) {
    $statusCode = 500;

    if ($e instanceof es\ucm\fdi\aw\http\ResponseStatusCode) {
        $statusCode = $e->getStatusCode();
    }
    http_response_code($statusCode);

    // La constante DEBUG está definida al comienzo del archivo con el resto de constantes.
    if (DEBUG) {
        echo "<!DOCTYPE html><html><head><title>Error</title></head><body><pre>";
        echo jTraceEx($e);
        echo "</pre></body></html>";
    } else {
  
        /**
        * Verificamos si el error lo tiene que procesar javascript -> application/json o lo va a ver directamente
        * el usuario final -> text/html
        */
        $mime = resolveContentNegotiation($_SERVER['HTTP_ACCEPT'], array('text/html', 'application/json'), 'text/html');
        switch($mime) {
            case 'application/json':
                $json = json_encode(es\ucm\fdi\aw\http\ErrorResponse::fromException($e), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
                header('Content-Type: application/json; charset=utf-8');
                header('Content-Length: ' . mb_strlen($json));

                echo $json;
            break;
            case 'text/html':
            default:
                // open the file in a binary mode
                $name = dirname(__DIR__).'/500.html';
                $fp = fopen($name, 'rb');

                // send the right headers
                header('Content-Type: text/html; charset=utf-8');
                header('Content-Length: ' . filesize($name));

                // dump the picture and stop the script
                fpassthru($fp);
            break;
        }
    }

    exit;  
});