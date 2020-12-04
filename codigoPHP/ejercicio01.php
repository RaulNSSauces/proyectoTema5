<?php

/* 
  * @author: Raúl Núñez Sebastián.
  * @since: 24-11-2020.
  * Ejercicio 1 - Desarrollo de un control de acceso con identificación del usuario basado en la función header().
*/

if (isset($_REQUEST['detalle'])) {
    header('Location: ejercicio00.php');
    exit;
}

if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    header('Location: http://192.168.0.203/proyectoTema5/indexProyectoTema5.php');
    exit;
}

    if($_SERVER['PHP_AUTH_USER']!="admin" || $_SERVER['PHP_AUTH_PW']!="paso"){
        header('WWW-Authenticate: Basic Realm="Contenido Restringido"');
        header('HTTP/1.0 401 Unauthorized');
        exit();
    }else{
        echo("<p><b>BIENVENIDO </b>".$_SERVER['PHP_AUTH_USER']."</p><br>");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <form name="formulario" method="post" enctype="multipart/form-data">
            <input type="submit" value="CERRAR SESIÓN" name="cerrarSesion">
            <input type="submit" value="DETALLE" name="detalle">
        </form>
    </body>
</html>