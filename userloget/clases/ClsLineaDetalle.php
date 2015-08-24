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
          if  (empty($_POST['txtLinea'])){$categoriaSelect=0;}else{ $categoriaSelect = $_POST['txtLinea'];}
          if  (empty($_POST['txtFuncionario'])){$funcionarioSelect=0;}else{ $funcionarioSelect = $_POST['txtFuncionario'];}
          if  (empty($_POST['txtFecha'])){$fecha=0;}else{ $fecha = $_POST['txtFecha'];}
          $database = 'salario';
            include '../funciones.php';
            conexionlocal();
            
             $codcategoria=$categoriaSelect;
             $codfuncionario=$funcionarioSelect;
           
            
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1){
                 if(func_existeDatoDetalle($codcategoria,$codfuncionario ,'linea_detalle', 'lin_cod','fun_cod', $database)){
                     
                     echo '<script type="text/javascript">
			alert("Este Detalle de Linea ya existe. Intente Ingresar otro Detalle..");
			 window.location="http://localhost/app/phpsueldosuserloget/FrmLineaDetNuevo.php";
			 </script>';
                       
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO linea_detalle(lin_cod, fun_cod, lin_fec) VALUES ($codcategoria,$codfuncionario,'$fecha');";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://localhost/app/phpsueldosuserloget/FrmLineaDetNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
                
                $query ='';
                $query = "update linea_detalle set fun_cod= $codfuncionario,lin_cod=$codcategoria,lin_fec='$fecha' where fun_cod= ".$codigo.";";
                $codacategoria=0;$codfuncionario=0;$fecha='';$codigo=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $codigo=0;
                $var=0;
                header("Refresh:0; url=http://localhost/app/phpsueldosuserloget/FrmLineaDetModif.php");
            }
       //
        ?>
    </body>
</html>
