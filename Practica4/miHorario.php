<?php

$tituloPagina = "Calendario";
$contenidoPrincipal = <<<HTML
<div class="container">
    <?php include 'calendario.php?events=eventos-personalizados.php'; ?>
</div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
