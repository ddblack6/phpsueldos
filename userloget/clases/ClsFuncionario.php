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
          if  (empty($_POST['txtCargo'])){$cargo=0;}else{ $cargo = $_POST['txtCargo'];}
          if  (empty($_POST['txtCargo2'])){$cargoSelect=0;}else{ $cargoSelect = $_POST['txtCargo2'];}
          if  (empty($_POST['txtCI'])){$ci=0;}else{ $ci = $_POST['txtCI'];}
          if  (empty( $_POST['txtNombre'])){$nombre =' ';}else{  $nombre = $_POST['txtNombre'];}
          if  (empty( $_POST['txtApellido'])){$apellido =' ';}else{$apellido = $_POST['txtApellido'];}
          if  (empty($_POST['checksituacion'])){ $situacion ='f';}else { $situacion = 't';}
          if  (empty(  $_POST['checkjubilado'])){$jubilado='f' ;}else{$jubilado= 't';}
          if  (empty(  $_POST['txtNroFicha'])){$ficha=0 ;}else{$ficha= $_POST['txtNroFicha'];}
          if  (empty(  $_POST['txtRadioFuente'])){$fuente='30' ;}else{$fuente= '10';}
          $database = 'salario';
            include '../funciones.php';
            conexionlocal();
           $cargo2=$cargoSelect;
            //invoca al php en donde estan contenidas las funciones
           // include '../conexion.php';
           
            
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1){
                 if(func_existeDato($ci, 'funcionario', 'fun_ci', $database)){
                     
                     echo '<script type="text/javascript">
			alert("El Funcionario ya existe. Intente Ingresar otro Funcionario..");
			 window.location="http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/FrmFuncionarioNuevo.php";
			 </script>';
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO funcionario(car_cod,fun_ci,fun_nom,fun_ape,fun_sit,fun_jdt,fun_fuente,fun_ficha) 
			VALUES ($cargo2,$ci, '$nombre', '$apellido', '$situacion', '$jubilado','$fuente',0);";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/FrmFuncionarioNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
                
                $query ='';
                $query = "update funcionario set fun_ci= $ci,car_cod=$cargo2,fun_nom='$nombre',
                fun_fuente='$fuente',fun_ficha='$ficha', fun_ape='$apellido', fun_sit='$situacion',
                fun_jdt='$jubilado' where fun_cod= ".$codigo.";";
                $ci=0;$cargo='';$nombre='';$apellido='';$situacion='';$jubilado='';$codigo=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $codigo=0;
                $var=0;
                header("Refresh:0; url=http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/FrmFuncionarioModif.php");
            }
       //
        ?>
    </body>
</html>
