<<<<<<< HEAD
<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['nombre']);
unset($_SESSION['esAdmin']);
unset($_SESSION['esMecanico']);
session_destroy();
header("Location: index.php");

=======
<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['nombre']);
unset($_SESSION['esAdmin']);
unset($_SESSION['esMecanico']);
session_destroy();
header("Location: index.php");

>>>>>>> c3d2392ea84a67af5b94d706eb9fe1d48bf813d7
?>