
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
        <title>Funcionarios</title>
        <link href="../Site.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
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
             
            location.href("http://192.168.0.99/web/phpsueldos2015/principal.php")
           
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
    $query = "delete from funcionario where fun_cod= ".$codigo.";"; 
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
             <div class="centerTable" >
                    <?php 
                  
                  // include './funciones.php';
                   //hace una conexion local
                     conexionlocal();
                      $result = pg_query("SELECT row_number()over (partition by 0 order by f.fun_cod) as   lineas, f.fun_cod,f.car_cod,f.fun_fuente,f.fun_ficha,c.car_des,f.fun_ci,f.fun_nom,f.fun_ape,f.fun_sit,f.fun_jdt FROM funcionario f, cargo c  where f.car_cod=c.car_cod order by fun_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                         echo " <caption>Eliminar Funcionarios (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Ficha Nº</th><th>Cargo</th><th>C.I. Nº</th><th>Nombre</th><th>Apellido</th><th>Activo</th><th>Jubilado</th><th>Fuente</th><th>Eliminar</th> \n"; 
                       do {
                           if($row["fun_sit"]=='t'){
                               $Activo='SI';
                           }
                           else{
                               $Activo='NO';
                           }
                           if($row["fun_jdt"]=='t'){
                               $Jubilado='SI';
                           }
                           else{
                               $Jubilado='NO';
                           }   
                           if($row["fun_fuente"]=='10'){
                               $Fuente='Fuente 10';
                           }
                           else{
                               $Fuente='Fuente 30';
                           } 
                            echo "<tr><td>".$row["lineas"]."</td><td>".$row["fun_cod"]."</td><td>".number_format($row["fun_ficha"], 0, '', '.')."</td><td>".$row["car_des"]."</td><td>".number_format($row["fun_ci"], 0, '', '.')."</td><td>".$row["fun_nom"]."</td><td>".$row["fun_ape"]."</td><td>".$Activo."</td><td>".$Jubilado."</td><td>".$Fuente."</td><td><span class='editar' value='".$row["fun_cod"]."' , OnClick='Eliminar(".$row["fun_cod"].");'>Borrar</span></td></tr> \n"; 
                       } 
                       while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                       echo "</br>";
                    }  else 
                        { 
                        echo "<p align=center>";
                        echo "¡ No se ha encontrado ningún registro !"; 
                        echo "</p>";
                        }
                  
                    ?> 
             </div>
                        
          <div class='clearfix'></div>
 </div>
<a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
    
    
</html>
