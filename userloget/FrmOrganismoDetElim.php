
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
        <title>Organismo Detalles</title>
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
             
            location.href("http://192.168.56.100/web/phpsueldos/principal.php")
           
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
    $query = "delete from organismo_detalle where fun_cod= ".$codigo.";"; 
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
                      $result = pg_query("SELECT row_number()over (partition by 0 order by ORG.org_cod) as   lineas, FUNC.fun_cod,ORG.org_des,FUNC.fun_ci,FUNC.fun_nom,FUNC.fun_ape,to_char(ORGDET.ord_fec,'DD/MM/YYYY')  as ord_fec FROM funcionario FUNC, organismo_detalle ORGDET,organismo ORG  where FUNC.fun_cod=ORGDET.fun_cod and FUNC.fun_sit='t' and ORGDET.org_cod=ORG.org_cod order by ORG.org_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                       echo " <caption>Eliminar Organismos Detalles (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Organismo</th><th>C.I. Nº</th><th>Nombre</th><th>Apellido</th><th>Fecha Organismo</th><th>Eliminar</th> \n"; 
                       do {
                            echo "<tr><td>".$row["lineas"]."</td><td>".$row["fun_cod"]."</td><td>".$row["org_des"]."</td><td>".$row["fun_ci"]."</td><td>".$row["fun_nom"]."</td><td>".$row["fun_ape"]."</td><td>".$row["ord_fec"]."</td><td><span class='editar' value='".$row["fun_cod"]."' , OnClick='Eliminar(".$row["fun_cod"].");'>Borrar</span></td></tr> \n"; 
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
