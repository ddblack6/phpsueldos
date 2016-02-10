<!DOCTYPE html>
<!--
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        
            <?php
            //recupera los datos del form
          if  (empty($_POST['txtcodigo'])){$codigo=0;}else{$codigo=$_POST['txtcodigo'];}
          if  (empty($_POST['txtci'])){$ci=0;}else{ $ci = $_POST['txtci'];}
          if  (empty( $_POST['txtusuario'])){$nick =' ';}else{$nick = $_POST['txtusuario'];}
          if  (empty( $_POST['txtnombre'])){$nombre =' ';}else{  $nombre = $_POST['txtnombre'];}
          if  (empty( $_POST['txtapellido'])){$apellido =' ';}else{$apellido = $_POST['txtapellido'];}
          if  (empty($_POST['txtpassword'])){ $password =' ';}else { $password = $_POST['txtpassword'];}
          if  (empty(  $_POST['txtemail'])){$mail=' ' ;}else{$mail= $_POST['txtemail'];}
           $database = 'salario';
            
            
            //invoca al php en donde estan contenidas las funciones
           // include '../conexion.php';
            include '../funciones.php';
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1){
                 if(func_existeDato($ci, 'usuario', 'usu_ci', $database)){
                     
                       echo('El usuario ya existe');
                       
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO usuario(usu_ci, usu_nick, usu_nom, usu_ape, usu_pas,email,usu_activo) VALUES ($ci, '$nick', '$nombre', '$apellido', MD5('$password'), '$mail','t');";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmusuarioNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
            conexionlocal();
                $query ='';
                $query = "update usuario set usu_ci= $ci , usu_nick='$nick', usu_nom='$nombre', usu_ape='$apellido', usu_pas=MD5('$password'),email='$mail' where usu_cod= ".$codigo.";";
                $ci=0;$nick='';$nombre='';$apellido='';$password='';$mail='';$codigo=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $codigo=0;
                $var=0;
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmusuarioModif.php");
            }
       //
        ?>
    </body>
</html>
