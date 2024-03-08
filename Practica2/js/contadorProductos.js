
function aumentarCantidad(nombreProducto, unidadesDisponibles) {
    var cantidadElement = document.getElementById(nombreProducto);
    var cantidad = parseInt(cantidadElement.innerText);

    // Incrementa la cantidad solo si es menor que las unidades disponibles
    if (cantidad < unidadesDisponibles) {
        cantidad++;
        cantidadElement.innerText = cantidad;
        document.getElementById(nombreProducto).innerText = cantidad; // Actualiza el mensaje de cantidad
    }
}

function disminuirCantidad(nombreProducto, unidadesDisponibles) {
    var cantidadElement = document.getElementById(nombreProducto);
    var cantidad = parseInt(cantidadElement.innerText);

    // Disminuye la cantidad solo si es mayor que 1
    if (cantidad > 1) {
        cantidad--; 
    }
    else{
        cantidad = unidadesDisponibles;
    }
    cantidadElement.innerText = cantidad;
    document.getElementById(nombreProducto).innerText = cantidad; // Actualiza el mensaje de cantidad
}

function agregarAlCarrito(nombreProducto) {
    var cantE = document.getElementById(nombreProducto);
    var cant = parseInt(cantE.innerText);

    alert(cant);
}