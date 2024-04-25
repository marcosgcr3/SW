# Ejemplo de uso de la librería Fullcalendar + API REST en PHP + MySQL #

Este proyecto ejemplifica:

1. Cómo utilizar la librería [fullcalendar](https://fullcalendar.io).

2. Cómo implementar un servicio REST en PHP (ver ```eventos.php```).

3. Cómo gestionar errores basados en excepciones (ver ```config.php -> function set_exception_handler``` y ```Evento.php```)

4. Cómo generar una salida apropiada para los errores dependiendo de si el destinatario es el usuario final o si
   está pensado para que el error sea procesado con javascript (ver ```config.php -> function set_exception_handler```)

5. Cómo organizar el código en múltiples namespaces.