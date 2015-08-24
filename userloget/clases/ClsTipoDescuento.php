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
          if  (empty($_POST['txtDescuentos'])){$descripcion=0;}else{ $descripcion = $_POST['txtDescuentos'];}
          
           $database = 'salario';
            
            
            //invoca al php en donde estan contenidas las funciones
           // include '../conexion.php';
            include 'funciones.php';
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1){
                 if(func_existeDato($descripcion, 'tipo_descuento', 'tde_des', $database)){
                     
                       echo '<script type="text/javascript">
			alert("Este Descuento ya existe. Intente Ingresar otro Tipo Descuento..");
			 window.location="http://localhost/app/phpsueldosuserloget/FrmTipoDescuentoNuevo.php";
			 </script>';
                       
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO tipo_descuento(tde_des) VALUES ('$descripcion');";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://localhost/app/phpsueldosuserloget/FrmTipoDescuentoNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
            conexionlocal();
                $query ='';
                $query = "update tipo_descuento set tde_des= '$descripcion' where tde_cod= ".$codigo.";";
                $descripcion=0;$codigo=0;
                $var=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                header("Refresh:0; url=http://localhost/app/phpsueldosuserloget/FrmTipoDescuentoModif.php");
            }
       //
        ?>
    </body>
</html>
