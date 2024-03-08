function aumentarCantidad(nombreProducto, unidadesDisponibles) {
    var cantidadElement = document.getElementById(nombreProducto);
    var cantidad = parseInt(cantidadElement.innerText);

    // Incrementa la cantidad solo si es menor que las unidades disponibles
    if (cantidad < unidadesDisponibles) {
        cantidad++;
        cantidadElement.innerText = cantidad;
    }
}

function disminuirCantidad(nombreProducto) {
    var cantidadElement = document.getElementById(nombreProducto);
    var cantidad = parseInt(cantidadElement.innerText);

    // Disminuye la cantidad solo si es mayor que 1
    if (cantidad > 1) {
        cantidad--;
        cantidadElement.innerText = cantidad;
    }
}