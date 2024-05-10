<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/productos/listado_tienda.php';

require_once 'includes/src/productos/producto.php';
require_once 'includes/vistas/plantillas/barraFiltrosTienda.php';

$tituloPagina = 'Tienda';

$contenidoPrincipal = '';

$contenidoPrincipal .= <<<EOS
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
EOS;

$contenidoPrincipal .= barraFiltros();
$contenidoPrincipal .= listaproductos();
   

$contenidoPrincipal .=<<<EOS
</div>
</body>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#filtrosP").click(function(){
                var min = $("#min").val();
                var max = $("#max").val();
                var categoria = $("#filtrosCat").val();
                //alert(min);
                //alert(max);
                //alert(categoria);
                $.ajax({
                    url:"procesaFiltroTienda.php",
                    type: "GET",
                    data:{min:min, max:max, categoria:categoria},
                    success:function(data){
                        $(".prueba").html(data);
                        console.log(data);
                    },
                    error: function(){
                        alert("Hubo un error");
                    }
                });
            });
        });

        $(document).ready(function(){
            $("#filtrosCat").on('change', function(){
                var min = $("#min").val();
                var max = $("#max").val();
                var categoria = $("#filtrosCat").val();
                //alert(min);
                //alert(max);
                //alert(categoria);
                $.ajax({
                    url:"procesaFiltroTienda.php",
                    type: "GET",
                    data:{min:min, max:max, categoria:categoria},
                    success:function(data){
                        $(".prueba").html(data);
                        console.log(data);
                    },
                    error: function(){
                        alert("Hubo un error");
                    }
                });
            });
        });
    </script>
EOS;


if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirProducto();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
