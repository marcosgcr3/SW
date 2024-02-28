function activoCheckBox(){
    checkbox = document.getElementById("mycheckbox");
    button = document.getElementById("myButton");
    nombre = document.getElementById("name");
    correo = document.getElementById("email");
    evaluacion = document.getElementById("evaluacion");
    sugerencias = document.getElementById("sugerencias");
    critica = document.getElementById("critica");
    consulta = document.getElementById("consultaBox");

    if(nombre.value == "")
        button.disabled = true;
    else if(correo.value =="")
        button.disabled = true;

    else if(!checkbox.checked)
        button.disabled = true;
    else if(!evaluacion.checked && !sugerencias.checked && !critica.checked)
        button.disabled = true;
    else if(consulta.value == "")
        button.disabled = true;
    else
        button.disabled = false;

    nombre.addEventListener("keyup", activoCheckBox);
    correo.addEventListener("keyup", activoCheckBox);
    evaluacion.addEventListener("change", activoCheckBox);
    sugerencias.addEventListener("change", activoCheckBox);
    critica.addEventListener("change", activoCheckBox);
    consulta.addEventListener("keyup", activoCheckBox);
}
