
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
        <title>Sueldos Pagados F-30</title>
        
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
            document.cookie ='varElim='+codigo; 
            alert("La operación se ha ejecutado con Éxito..");
            }
            else {
            // si pulsamos en cancelar
          alert("Operación cancelada..");
            } 
         
    }
         function Modificar(codigo) {
           
           //paso este dato a mi php
                document.cookie ='varMod='+codigo; 
                document.cookie =0;
                
         }
    
        function Refrescar(){
            
           location.reload();
        }
        function Cancelar(){
             
            location.href("http://localhost/app/phpsueldosprincipal.php")
           
        }
    </script>
<?php
include './funciones.php';
/************************************************************************************************
 * Esta parte del codigo php elimina el registro 
 * 
 */ 
if  (empty($_COOKIE["varElim"])){
     $codigo=0;
 }  
 else{
    conexionlocal();
    try{
    $codigo = $_COOKIE["varElim"];
    setcookie("varElim", $_COOKIE["varElim"], time()+12);
    $query = "delete from descuento where sal_cod= ".$codigo.";"; 
    $ejecucion = pg_query($query)or die('Error Al Eliminar el Dato');
    $query = "delete from salario where sal_cod= ".$codigo.";"; 
    $ejecucion = pg_query($query)or die('Error Al Eliminar el Dato');
    $codigo=0;
    }  catch (ExceptionType $e){
        echo "<script type='text/javascript'>alert('Error al ejecutar la operacion);</script>";
        $codigo=0;
    }
 }
 //************************Esta parte Realizo la redireccion a modificar FrmModifSalario.php******************************
if  (empty($_COOKIE["varMod"])){
     $valueMod=0;    
 }  else
 {
     $valueMod = $_COOKIE["varMod"];
     header('Location: http://localhost/app/phpsueldosuserloget/FrmModifSalario.php');
     setcookie("varMod", $_COOKIE["varMod"], time()+12);
     
     
 }   
 
?>
    </head>
    <body>
         <?php include("principal.php");?>
  
    
        <div class='clearfix'></div>
        
     
             <div class="centerTable" >
                    <?php
                     conexionlocal();
                      $result = pg_query("SELECT row_number()over (partition by 0 order by max(SAL.sal_cod)) as lineas,max(lin.lin_des) as lin_des,
                    max(Sal.usu_cod) as usu_cod ,max(Sal.sal_cod)as sal_cod,max(Sal.fun_cod) as fun_cod,max(CONCAT(FUN.fun_nom,' ',FUN.fun_ape)) as nombres,max(FUN.fun_ci) as cin,max(to_char(SAL.sal_fecha,'dd/mm/yyyy')) as sal_fecha,
                    max(cat.cat_nom) as sueldobruto,max(SAL.sal_ips) as sal_ips,max(SAL.sal_aus) as sal_aus,max(SAL.sal_pyt) as sal_pyt,max(SAL.sal_jud) as sal_jud,max(SAL.sal_aso) as sal_aso,max(SAL.sal_rep)as sal_rep,sum(DES.ode_mon) as ode_mon,'Otros Descuentos' as tde_des,max(SAL.sal_neto) as sal_neto 
                   ,(max(SAL.sal_ips)+ max(SAL.sal_aus)+max(SAL.sal_pyt)+max(SAL.sal_jud)+max(SAL.sal_aso)+max(SAL.sal_rep)) as total_descuentos from Salario SAL
                    LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
                    LEFT OUTER JOIN tipo_descuento TIPDES
                    on TIPDES.tde_cod=DES.tde_cod
                    INNER JOIN funcionario FUN 
                    on SAl.fun_cod=FUN.fun_cod
                    INNER JOIN categoria_detalle catdet
                    on sal.fun_cod= catdet.fun_cod
                    INNER JOIN categoria cat
                    on cat.cat_cod=catdet.cat_cod
                    INNER JOIN linea_detalle lindet
                    on sal.fun_cod= lindet.fun_cod
                    INNER JOIN linea lin
                    on lindet.lin_cod=lin.lin_cod
                    where SAL.fun_cod=FUN.fun_cod and FUN.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now()) group by FUN.fun_cod order by sueldobruto desc");
                    if ($row = pg_fetch_array($result)){
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                       echo " <caption>Sueldos Registrados (Presione Crtl + F para buscar)</caption>";
                       echo "<th><strong>Item</strong></th><th><strong>Línea</strong></th><th><strong>Cedula Nro</strong></th><th><strong>Nombres</strong></th><th><strong>Fecha Salario</strong></th><th><strong>Sueldo Bruto</strong></th><th><strong>IPS</strong></th>
                           <th><strong>Ausencias</strong></th><th><strong>Permisos y Llegadas Tardías</strong></th><th><strong>Descuentos Judiciales</strong></th>
                           <th><strong>ASO</strong></th><th><strong>Reposo</strong></th><th><strong>Otros Descuentos</strong></th><th><strong>Monto Otros Descuentos</strong></th><th><strong>Total Descuentos</strong></th>
                           <th><strong>Neto a Cobrar</strong></th><th><strong>Modificar</strong></th><th><strong>Eliminar</strong></th> \n"; 
                      $indice=0;
                       do {
                      $indice=$indice + 1;    
                       if ($row["ode_mon"]==''){$otrosDes=0;}else{$otrosDes=$row["ode_mon"];}
                       echo "<tr><td>".$indice."</td><td>".number_format($row["lin_des"], 0, '', '.')."</td><td>".number_format($row["cin"], 0, '', '.')."</td><td>".$row["nombres"]."</td><td>".$row["sal_fecha"]."</td><td>".number_format($row["sueldobruto"], 0, '', '.')."</td><td>".number_format($row["sal_ips"], 0, '', '.')."</td><td>".number_format($row["sal_aus"], 0, '', '.')."</td><td>".number_format($row["sal_pyt"], 0, '', '.')."</td>
                       <td>".number_format($row["sal_jud"], 0, '', '.')."</td><td>".number_format($row["sal_aso"], 0, '', '.')."</td><td>".number_format($row["sal_rep"], 0, '', '.')."</td><td>".$row["tde_des"]."</td><td>".number_format($otrosDes, 0, '', '.')."</td><td>".number_format($row["total_descuentos"]+$otrosDes, 0, '', '.')."</td><td>".number_format($row["sal_neto"], 0, '', '.')."</td>
                       <td><span class='editar' value='".$row["sal_cod"]."' , OnClick='Modificar(".$row["sal_cod"].");'>Editar</span></td><td><span class='editar' value='".$row["sal_cod"]."' , OnClick='Eliminar(".$row["sal_cod"].");'>Borrar</span></td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                       echo "</br>";
                    }  else 
                        { 
                        echo "<p align=center>";
                        echo "¡ No se ha encontrado ningún registro !"; 
                        echo "</p>";
                        }
                    ?> 
              
                 <?php
                     conexionlocal();
                      $result = pg_query("SELECT 'XXXX' as lineas, 'XXXXXXX'  as nombres,'XXXXXXXX' as sal_fecha, 'XXXXXXXX' as tde_des,sum(SAL.sal_ips)as ips,sum(SAL.sal_aus)as ausencia,sum(SAL.sal_pyt)as permiso,sum(SAL.sal_jud)as judicial,
                        sum(SAL.sal_aso)as aso,sum(SAL.sal_rep)as reposo,sum(DES.ode_mon)as descuentos,
                        sum(SAL.sal_neto) as totalneto
                        from Salario SAL
                        LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
                        INNER JOIN funcionario FUN 
                        on SAl.fun_cod=FUN.fun_cod 
                        LEFT OUTER JOIN tipo_descuento TIPDES
                        on TIPDES.tde_cod=DES.tde_cod
                        where SAL.fun_cod=FUN.fun_cod and FUN.fun_fuente='30' and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                        and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      
                      //total de sueldo bruto
                       $bruto=pg_query("select sum(c.cat_nom)as sueldobruto from salario s,categoria c,categoria_detalle cd ,funcionario fun where  fun.fun_cod=s.fun_cod and fun.fun_fuente='30'
                          and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())
                    and c.cat_cod=cd.cat_cod and cd.fun_cod=s.fun_cod");
                      $row00=pg_fetch_array($bruto);
                      //total de sueldo neto
                      $neto=pg_query("select sum(s.sal_neto)as saldoneto from salario s, funcionario fun where  fun.fun_cod=s.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row1=pg_fetch_array($neto);
                      //total de IPS
                      $totalIPS=pg_query("select sum(s.sal_ips) as sal_ips from salario s,funcionario fun where s.fun_cod=fun.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row2=pg_fetch_array($totalIPS);
                      //total ausencia
                      $totalAus=pg_query("select sum(s.sal_aus) as ausencia from salario s,funcionario fun where s.fun_cod=fun.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row3=pg_fetch_array($totalAus);
                      //para permiso y llegadas tardias
                      $totalPermiso=pg_query("select sum(s.sal_pyt) as permiso from salario s,funcionario fun where s.fun_cod=fun.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row4=pg_fetch_array($totalPermiso);
                      //para descuento judicialez
                      $totalJudiciales=pg_query("select sum(s.sal_jud) as judiciales from salario s,funcionario fun where s.fun_cod=fun.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row5=pg_fetch_array($totalJudiciales);
                      //para descuento ASO
                      $totalASO=pg_query("select sum(s.sal_aso) as aso from salario s,funcionario fun where s.fun_cod=fun.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row6=pg_fetch_array($totalASO);
                      //para descuento reposo
                      $totalReposo=pg_query("select sum(s.sal_rep) as reposo from salario s,funcionario fun where s.fun_cod=fun.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row7=pg_fetch_array($totalReposo);
                      //para total descuentos(otros)
                      $totalOdescuentos=pg_query("select sum(d.ode_mon) as descuentos from descuento d, funcionario fun,salario sal where sal.sal_cod=d.sal_cod and fun.fun_cod=sal.fun_cod and fun.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())");
                      $row8=pg_fetch_array($totalOdescuentos);
                    
                    if ($row = pg_fetch_array($result)){
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                       echo " <caption>Sumas Totales</caption>"; 
                      echo "<th><strong>Línea</strong></th><th><strong>Nombres</strong></th><th><strong>Fecha Salario</strong></th><th><strong>Total Bruto</strong></th><th><strong>Total IPS</strong></th>
                           <th><strong>Total Ausencias</strong></th><th><strong>Total Permisos y Llegadas Tardías</strong></th><th><strong>Total Descuentos Judiciales</strong></th>
                           <th><strong>Total ASO</strong></th><th><strong>Total Reposo</strong></th><th><strong>Otros Descuentos</strong></th><th><strong>Total Otros Descuentos</strong></th>
                           <th><strong>Total Neto a Cobrar</strong></th> \n"; 
                       do { 
                       echo "<tr><td>".$row["lineas"]."</td><td>".$row["nombres"]."</td><td>".$row["sal_fecha"]."</td><td>".number_format($row00["sueldobruto"], 0, '', '.')."</td><td>".number_format($row2["sal_ips"], 0, '', '.')."</td><td>".number_format($row3["ausencia"], 0, '', '.')."</td><td>".number_format($row4["permiso"], 0, '', '.')."</td>
                       <td>".number_format($row5["judiciales"], 0, '', '.')."</td><td>".number_format($row6["aso"], 0, '', '.')."</td><td>".number_format($row7["reposo"], 0, '', '.')."</td><td>".$row["tde_des"]."</td><td>".number_format($row8["descuentos"], 0, '', '.')."</td><td>".number_format($row1["saldoneto"], 0, '', '.')."</td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                       echo "</br>";
                    }  else 
                        { 
                        echo "<p align=center>";
                        echo "¡ No se ha encontrado ningún registro !"; 
                        echo "</p>";
                        }
                    ?> 
                 </br></br></br></br>
             </div>
          <div class='clearfix'></div>
          <div id="twitter">
          <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
          <a href="http://localhost/app/phpsueldosuserloget/informes/InformeSueldoF30.php"><img src="img/boton_pdf_descarga.png" title="Enviar a PDF" style="position:center; bottom: 50px; left: 6%;" /></a>
          <a href="http://localhost/app/phpsueldosuserloget/excel/InformeExcelF30.php"><img src="img/btnexcel.jpg" title="Enviar a Excel" style="position:absolute; bottom: 50px; left: 95%;" /></a>
          </div> 
</body>
    
    
</html>
