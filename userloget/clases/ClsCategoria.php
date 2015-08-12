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
          if  (empty($_POST['txtCategoria'])){$descripcion=0;}else{ $descripcion = $_POST['txtCategoria'];}
          if  (empty($_POST['txtMonto'])){$monto=0;}else{ $monto = $_POST['txtMonto'];}
          
           $database = 'salario';
            
            
            //invoca al php en donde estan contenidas las funciones
           // include '../conexion.php';
            include '../funciones.php';
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1){
                 if(func_existeDato($descripcion, 'categoria', 'cat_des', $database)){
                     
                        echo '<script type="text/javascript">
			alert("La Categoria ya existe. Intente Ingresar otra Categoria..");
			 window.location="http://localhost/app/phpsueldos/userloget/FrmCategoriaNuevo.php";
			 </script>';
                       
                      }else{              
                            //se define el Query   
                            $query = "INSERT INTO categoria(cat_des,cat_nom) VALUES ('$descripcion',$monto);";
                            //ejecucion del query
                            $ejecucion = pg_query($query)or die('Error al realizar la carga');
                            $query = '';
                            $var=0;
                            header("Refresh:0; url=http://localhost/app/phpsueldos/userloget/FrmCategoriaNuevo.php");
                            }
         }
           //si el registro es en modificar modificar
        elseif ($var==2){
            conexionlocal();
                $query ='';
                $query = "update categoria set cat_des= '$descripcion',cat_nom=$monto where cat_cod= ".$codigo.";";
                $descripcion=0;$codigo=0;
                $var=0;
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                header("Refresh:0; url=http://localhost/app/phpsueldos/userloget/FrmCategoriaModif.php");
            }
       //
        ?>
    </body>
</html>
