<?php

/* 
  * @author: Raúl Núñez Sebastián.
  * @since: 24-11-2020.
  * Ejercicio 2 - Desarrollo de un control de acceso con identificación del usuario basado en la función header().
*/

if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])){
    header('WWW-Authenticate: Basic Realm="Contenido Restringido"');
    header('HTTP/1.0 401 Unauthorized');
    exit();
}
if(isset($_REQUEST['detalle'])) {
    header('Location: ejercicio00.php');
        exit;
    }
if(isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    header('Location: http://192.168.0.203/proyectoTema5/indexProyectoTema5.php');
    exit;
}
    
    require_once '../config/confDBPDO.php';
    
    try{
        $miDB = new PDO(DNS, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
        $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.
        
        $sql="SELECT T01_CodUsuario, T01_Password from T01_Usuario where T01_CodUsuario=:CodUsuario";
        
        $consulta=$miDB->prepare($sql);
        
        $parametros=[":CodUsuario" => $_SERVER['PHP_AUTH_USER']];
        
        $consulta->execute($parametros);
        
        $resultado=$consulta->fetchObject();
        
        if($consulta->rowCount()>0){
            $password=hash('sha256', $_SERVER['PHP_AUTH_USER'].$_SERVER['PHP_AUTH_PW']);
            $usuario=$_SERVER['PHP_AUTH_USER'];
            
            if($password==$resultado->T01_Password && $usuario==$resultado->T01_CodUsuario){
                echo "<h3>Bienvenido ".$usuario."</h3>";
            }
        }   
    }catch(PDOException $miExcepcionPDO){
        echo "<p style='color:red;'>Error ".$miExcepcionPDO->getMessage()."</p>"; //Muestro el mensaje de la excepción de errores.
        echo "<p style='color:red;'>Código de error ".$miExcepcionPDO->getCode()."</p>"; //Muestro el código del error.
    }finally{
        unset($miDB);
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