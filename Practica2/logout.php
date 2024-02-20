<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['nombre']);
unset($_SESSION['esAdmin']);
unset($_SESSION['esMecanico']);
session_destroy();
echo "<h2><a href='index.php' >SESION CERRADA</a></h2>";

?>