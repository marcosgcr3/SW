<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\alquilar\alquilar;
use es\ucm\fdi\aw\vehiculos\vehiculo;
require_once 'includes/config.php';
require_once 'includes/src/vehiculos/listado_vehiculos.php';

require_once 'includes/vistas/plantillas/barraFiltrosAlquiler.php';

$tituloPagina = 'Alquiler';

$contenidoPrincipal = '';

$contenidoPrincipal .= <<<EOS
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
EOS;

$contenidoPrincipal .= barraFiltros();


    Vehiculo::comprobarDisponibilidadTodos();
    // Alquilar::comprobarFecha()
    $contenidoPrincipal .=<<<EOS
        <div class="prueba">
    EOS;

    $contenidoPrincipal .= listavehiculos();
 

$contenidoPrincipal .=<<<EOS
</div>
</body>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#filtrosC").on('change', function(){
                var marca = $(this).val();
                var min = $("#min").val();
                var max = $("#max").val();
                var anyo = $("#filtrosA").val();
                //alert(min);
                //alert(max);
                //alert(marca);
                //alert(anyo);
                $.ajax({
                    url:"procesaFiltrosAlquiler.php",
                    type: "GET",
                    data: {marca:marca, min:min, max:max, anyo:anyo},
                    success:function(data){
                        $(".prueba").html(data);
                    },
                    error: function(){
                        console.log(data);
                        alert("Hubo un error");
                    }
                });
            });
        });

        $(document).ready(function(){
            $("#filtrosA").on('change', function(){
                var anyo = $(this).val();
                var min = $("#min").val();
                var max = $("#max").val();
                var marca = $("#filtrosC").val();
                //alert(min);
                //alert(max);
                //alert(marca);
                //alert(anyo);
                $.ajax({
                    url:"procesaFiltrosAlquiler.php",
                    type: "GET",
                    data:{marca:marca,min:min,max:max,anyo:anyo},
                    success:function(data){
                        $(".prueba").html(data);
                        console.log(data);
                    },
                    error: function(){
                        console.log(data);
                        alert("Hubo un error");
                    }
                });
            });
        });

        $(document).ready(function(){
            $("#filtrosP").click(function(){
                var min = $("#min").val();
                var max = $("#max").val();
                var marca = $("#filtrosC").val();
                var anyo = $("#filtrosA").val();
                //alert(min);
                //alert(max);
                //alert(marca);
                //alert(anyo);
                $.ajax({
                    url:"procesaFiltrosAlquiler.php",
                    type: "GET",
                    data:{marca:marca,min:min,max:max,anyo:anyo},
                    success:function(data){
                        $(".prueba").html(data);
                        console.log(data);
                    },
                    error: function(){
                        console.log(data);
                        alert("Hubo un error");
                    }
                });
            });
        });
    </script>
EOS;

if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirVehiculo();
}
   
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
