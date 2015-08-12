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
          if  (empty($_POST['txtOrganismo'])){$organismoSelect=0;}else{ $organismoSelect= $_POST['txtOrganismo'];}
          if  (empty($_POST['txtFuncionario'])){$funcionarioSelect=0;}else{ $funcionarioSelect = $_POST['txtFuncionario'];}
          if  (empty($_POST['txtFecha'])){$fecha=0;}else{ $fecha = $_POST['txtFecha'];}
          $database = 'salario'; 
            include '../funciones.php';
            conexionlocal();
           $codorganismo=$organismoSelect;
           $codfuncionario=$funcionarioSelect;
            //invoca al php en donde estan contenidas las funciones
           // include '../conexion.php';
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1){
                 if(func_existeDatoDetalle($codorganismo,$codfuncionario ,'organismo_detalle', 'org_cod','fun_cod', $database)){
                     
                         echo '<script type="text/javascript">
			alert("El Detalle de Organismo ya existe. Intente Ingresar otro Detalle..");
			 window.location="http://localhost/app/phpsueldos/userloget/FrmOrganismoDetNuevo.php";
			 </script>';
                       
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO organismo_detalle(org_cod, fun_cod, ord_fec) VALUES ($codorganismo,$codfuncionario,'$fecha');";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://localhost/app/phpsueldos/userloget/FrmOrganismoDetNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
                
                $query ='';
                $query = "update organismo_detalle set fun_cod= $codfuncionario,org_cod=$codorganismo,ord_fec='$fecha' where fun_cod= ".$codigo.";";
                $codorganismo=0;$codfuncionario=0;$fecha='';$codigo=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $codigo=0;
                $var=0;
                header("Refresh:0; url=http://localhost/app/phpsueldos/userloget/FrmOrganismoDetModif.php");
            }
       //
        ?>
    </body>
</html>
