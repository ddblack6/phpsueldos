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
          if  (empty($_POST['txtCategoria'])){$categoriaSelect=0;}else{ $categoriaSelect = $_POST['txtCategoria'];}
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
                 if(func_existeDatoDetalle($codcategoria,$codfuncionario ,'categoria_detalle', 'cat_cod','fun_cod', $database)){
                     
                      echo '<script type="text/javascript">
			alert("El detalle ya existe. Intente Ingresar otro Detalle de Categoria..");
			 window.location="http://192.168.0.99/web/phpsueldos/userloget/FrmCategoriaDetNuevo.php";
			 </script>';
                       
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO categoria_detalle(cat_cod, fun_cod, cad_fec) VALUES ($codcategoria,$codfuncionario,'$fecha');";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://192.168.0.99/web/phpsueldos/userloget/FrmCategoriaDetNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
                
                $query ='';
                $query = "update categoria_detalle set fun_cod= $codfuncionario,cat_cod=$codcategoria,cad_fec='$fecha' where fun_cod= ".$codigo.";";
                $codacategoria=0;$codfuncionario=0;$fecha='';$codigo=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $codigo=0;
                $var=0;
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos/userloget/FrmCategoriaDetModif.php");
            }
       //
        ?>
    </body>
</html>
