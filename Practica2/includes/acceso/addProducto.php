<?php

function buildFormularioProducto($nombre='', $precio='', $descripcion='', $unidades='', $imagen='')
{
    return <<<EOS
    <div class="container-registro">
        <h2>Registro Producto</h2>

        <form action="procesaRegistroProducto.php" method="post">
            
            <p>Nombre:</p>
            <input type="text" name="nombre" id="nombre" value="$nombre" required>
            <p>Precio:</p>
            <input type="text" name="precio" id="precio" value="$precio" required>
            <p>Descripcion:</p>
            <input type="text" name="descripcion" id="descripcion" value="$descripcion" required>
            <p>Unidades:</p>
            <input type="text" name="unidades" id="unidades" value="$unidades" required>
            <p>Imagen:</p>
            <input type="text" name="imagen" id="imagen" value="$imagen" required>
            <p></p>
            <input type="submit" value="Registrar">
        </form>
    </div>
    EOS;
}
