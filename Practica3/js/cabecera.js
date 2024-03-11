let menuVisible = false;
//Función que oculta o muestra el menu
function mostrarOcultarMenu(){
    if(menuVisible){
        document.getElementById("nav").classList.remove("responsive");
        menuVisible = false;
    }else{
        document.getElementById("nav").classList.add("responsive");
        menuVisible = true;
    }
}

 
function cambiarTema(){
    cambiarCSS(); 
    location.reload();

}
function cambiarCSS(){
    var tema =  document.getElementById('estilo').getAttribute('href');
   
    if(tema === 'css/index.css'){
        document.cookie = "modoOscuro=activado";
    }
    else{
        document.cookie = "modoOscuro=desactivado";
    }
}




function aumentarCantidad(nombreProducto, unidadesDisponibles) {
    var cantidadElement = document.getElementById(nombreProducto);
    var cantidad = parseInt(cantidadElement.innerText);

    // Incrementa la cantidad solo si es menor que las unidades disponibles
    if (cantidad < unidadesDisponibles) {
        cantidad++;
    }
    else{
        cantidad = 1;
    }
    cantidadElement.innerText = cantidad;
    document.getElementById(nombreProducto).innerText = cantidad; // Actualiza el mensaje de cantidad
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