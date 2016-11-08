
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tipo Descuentos</title>
        <link href="../Site.css" rel="stylesheet">
        
        <meta name="viewport" content="width=device-width" />
        <!//<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
        <link rel="stylesheet" href="twitter-signup.css" type="text/css" />
         <link href="../tabla.css" rel="stylesheet">
        <script type="text/javascript">
            var variablejs;
        function Eliminar(codigo) {

            confirmar=confirm("Esta seguro que desea Eliminar?"); 
            if (confirmar){ 
            // si pulsamos en aceptar
            document.cookie ='var2='+codigo; 
            alert("La operación se ha ejecutado con Éxito..");
            }
            else {
            // si pulsamos en cancelar
          alert("Operación cancelada..");
            } 
    }
        function Refrescar(){
            
           location.reload();
        }
        function Cancelar(){
             
            location.href("http://aplicaciones.intn.gov.py/web/phpsueldos2016/principal.php")
           
        }
    </script>
<?php
include './funciones.php';
 if  (empty($_COOKIE["var2"])){
     $codigo=0;
 }  
 else{
    conexionlocal();
    try{
    $codigo = $_COOKIE["var2"];
    setcookie("var2", $_COOKIE["var2"], time()+12);
    $query = "delete from tipo_descuento where tde_cod= ".$codigo.";"; 
    $ejecucion = pg_query($query)or die('Error Al Eliminar el Dato');
    $codigo=0;
    }  catch (ExceptionType $e){
        echo "<script type='text/javascript'>alert('Error al ejecutar la operacion);</script>";
        $codigo=0;
    }
 }
?>
    </head>
    <body>
    <?php include("principal.php");?>
    <div id="twitter">
    
        <div class='clearfix'></div>
        

     
                    <?php 
                  
                  // include './funciones.php';
                   //hace una conexion local
                     conexionlocal();
                      $result = pg_query("SELECT row_number()over (partition by 0 order by tde_cod) as   lineas, tde_cod,tde_des FROM tipo_descuento order by tde_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                       echo " <caption>Eliminar Tipos Descuentos (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Descripción</th><th>Eliminar</th> \n"; 
                       do { 
                       echo "<tr><td>".$row["lineas"]."</td><td>".$row["tde_cod"]."</td><td>".$row["tde_des"]."</td><td><span class='editar' value='".$row["tde_cod"]."' , OnClick='Eliminar(".$row["tde_cod"].");'>Borrar</span></td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                       echo "</br>";
                    }  else 
                        { 
                        echo "¡ No se ha encontrado ningún registro !"; 
                        }
                  
                    ?> 
            
                        
          <div class='clearfix'></div>
 </div>
<a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
    
    
</html>
