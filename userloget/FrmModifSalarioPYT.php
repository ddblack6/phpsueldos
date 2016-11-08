<?php
session_start();
?>
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
        <title>Salarios Fuente 10</title>
        <link href="../Site.css" rel="stylesheet">
        <link href="../tabla.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
		<link rel="stylesheet" href="twitter-signup.css" type="text/css" />
                
       <script>
         function Refrescar(){
           location.reload();
        }
        function ActualizaInput(){
            document.getElementById("cin").value = " ";
            document.getElementById("organismo").value = " ";
            document.getElementById("categoria").value = " ";  
        }
         function ActualizaInputDetalle(){
            document.getElementById("montos").value = " ";
         }
        
        
        //descuento de 20 por Permiso o LLegada tardia
         function Descuento20(){
             //recuperamos el valor descuento20 anterior
             var descuento20=document.getElementById("sal_pyt20").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento20 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento20);
                 document.getElementById("sueldoNeto").value=suma;
                }
             //sueldo bruto inicial
             var SueldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=Math.round(SueldoBrutoIni/30);
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('descuento20').value;
             //descuento por dia de 20 %
             var descuento20=Math.round(((jornal*20)/100));
             //obtener el valor actual del sal_pyt//esto se debe sumar al total de descuento  sal aso
             //de 20, 40 y 50 por ciento.
             document.getElementById("sal_pyt20").value=(descuento20*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuento20*dias);
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
            var sueldoneto=document.getElementById('sueldoNeto').value;
            document.getElementById("sal_neto").value=sueldoneto;
        }
        //descuento de 40 por Permiso o LLegada tardia
        function Descuento40(){
             //recuperamos el valor descuento40 anterior
             var descuento40=document.getElementById("sal_pyt40").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento40 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento40);
                 document.getElementById("sueldoNeto").value=suma;
                }
             //sueldo bruto inicial
             var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=Math.round(SaldoBrutoIni/30);
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('descuento40').value;
             //descuento por dia de 40 %
             var descuento40=Math.round(((jornal*40)/100))
             //actualizar valor de sal_pyt
              document.getElementById("sal_pyt40").value=(descuento40*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuento40*dias);
             
             
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
        }
        
        //descuento de 50 por ciento por permiso o llegada tardia
        function Descuento50(){
             //recuperamos el valor descuento50 anterior
             var descuento50=document.getElementById("sal_pyt50").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento50 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento50);
                 document.getElementById("sueldoNeto").value=suma;
                }
             //sueldo bruto inicial
             var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=Math.round(SaldoBrutoIni/30);
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('descuento50').value;
             //descuento por dia de 50 %
             var descuento50=Math.round(((jornal*50)/100));
            
             //actualizar valor de sal_pyt
              document.getElementById("sal_pyt50").value=(descuento50*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuento50*dias);
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
        }
        
</script>
    </head>
    <body>
    <?php include("principal.php"); ?>
        
        <?php
        include './funciones.php';
        conexionlocal();
        /*
         * To change this template, choose Tools | Templates
         * and open the template in the editor.
         */
        if  (empty($_COOKIE["varMod"])){
        $codigo=0;    
         }  else
         {
             $codigo = $_COOKIE["varMod"];
             /* aca empezamos nuestra consulta de salario*/
             $query = "select FUNC.fun_cod as CODIGOFUNCIONARIO,--0
             FUNC.fun_nom as NOMBRE,--1
             FUNC.fun_ape as APELLIDO,--2
             FUNC.fun_ci as CI,--3
             SAL.sal_cod,--4
             SAL.usu_cod,--5
             SAL.fun_cod,--6
             SAL.sal_fecha,--7
             SAL.sal_ips,--8
             SAL.sal_aus,--9
             SAL.sal_pyt,--10
             SAL.sal_jud,--11
             SAL.sal_aso,--12
             SAL.sal_rep,--13
             SAL.sal_neto,--14
             SAL.sal_aus,--15
             CAT.cat_nom,--16
             Sal.sal_pyt20,--17
             Sal.sal_pyt40,--18
             Sal.sal_pyt50--19
             from salario SAL, funcionario FUNC,categoria CAT,categoria_detalle CATDET 
             where SAL.fun_cod=FUNC.fun_cod 
             and FUNC.fun_cod=CATDET.fun_cod
             and CATDET.cat_cod=CAT.cat_cod and SAL.sal_cod=".$codigo;
             $resultadoSelect = pg_query($query);
             $rowP = pg_fetch_row($resultadoSelect);
         }
        ?>
    <div id="twitter">  
        <div class='clearfix'></div>
                    <table> <caption>Datos del Funcionario</caption>  </table>
                    <div class='clearfix'></div>
                    <div id='name' class='outerDiv'>  
                    <label for="txtNombre">Nombre:</label> 
                    <input type="text" style="background-color:#EfEfEf " name="txtNombre" id="cin" readonly="true" value="<?php if(empty ($rowP[1])){$value=0;}else{$value=$rowP[1].' '.$rowP[2];echo$value;}?>" required  /> 
                    </div>
                    <div class='clearfix'></div>
                    <div id='name' class='outerDiv'>    
                    <label for="txtCI">CI Nº</label> 
                    <input type="text" name="txtCI" style="background-color:#EfEfEf " id="cin" maxlength="9" readonly="true" value="<?php if(empty ($rowP[3])){$value=0;}else{$value=$rowP[3];echo$value;}?>" required  /> 
                    </div>
                    <div class='clearfix'></div> 
                    <div id='name' class='outerDiv'>
                    <label for="txtSueldo">Sueldo Bruto:</label> 
                    <input type="number" name="txtSueldo" style="background-color:#EfEfEf " id="sueldoBruto" readonly="true"  value="<?php if(empty ($rowP[16])){$value=0;}else{$value=$rowP[16];echo$value;}?>" required  /> 
                    </div>
                  <div class='clearfix'></div> 
                    <div id='name' class='outerDiv'>
                    <label for="txtSueldoNeto">Sueldo Neto:</label> 
                    <input type="number" name="txtSueldoNeto" step="0" style="background-color:#ff0 " id="sueldoNeto" readonly="true"  value="<?php if(empty ($rowP[14])){$value=0;}else{$value=$rowP[14];echo $value;}?>" required  /> 
                    </div>
                    <div class='clearfix'></div>
                    </br></br>
 
 <table>
                      <caption>Permisos y Llegadas Tardías </caption>  
                         <th> 20% </th><th> 40% </th><th> 50% </th>   
                        <tr>
                            <td>
                            <fieldset>
                            <legend align= "left">20%</legend>
                            <input type=radio name="ausen20" value=1>Descontar <br>
                            <input type=radio name="ausen20" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='dia' id='descuento20' onchange='Descuento20()'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                        <td>
                            <fieldset>
                            <legend align= "left">40%</legend>
                            <input type=radio name="ausen40" value=1>Descontar <br>
                            <input type=radio name="ausen40" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='dia' id='descuento40' onchange='Descuento40()'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                            <td>
                            <fieldset>
                            <legend align= "left">50%</legend>
                            <input type=radio name="ausen50" value=1>Descontar <br>
                            <input type=radio name="ausen50" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='dia' id='descuento50' onchange='Descuento50()'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                             
                            </tr>
            </table>
            <div class='clearfix'></div>
            
                    <form action="clases/ClsSalario.php?nuevo=7" method="post" onClik="submit" >
                    <input type="hidden" name="Nfun_cod" value="<?php if(empty ($rowP[6])){$value=0;}else{$value=$rowP[6];echo $value;}?>"/> 
                    <input type="hidden" id="sal_pyt20" name="Nsal_pyt20" value="<?php if(empty ($rowP[17])){$value=0;}else{$value=$rowP[17];echo $value;}?>" >
                    <input type="hidden" id="sal_pyt40" name="Nsal_pyt40"  value="<?php if(empty ($rowP[18])){$value=0;}else{$value=$rowP[18];echo $value;}?>" >
                    <input type="hidden" id="sal_pyt50" name="Nsal_pyt50" value="<?php if(empty ($rowP[19])){$value=0;}else{$value=$rowP[19];echo $value;}?>" >
                    <input type="hidden" id="sal_pyt" name="Nsal_pyt"  value="<?php if(empty ($rowP[10])){$value=0;}else{$value=$rowP[10];echo $value;}?>" >
                    <input type="hidden" id="sal_cod" name="Nsal_cod"  value="<?php if(empty ($codigo)){$value=0;}else{$value=$codigo;echo $value;}?>" >
                    <input type="hidden" id="sal_neto" name="Nsal_neto" value="<?php if(empty ($rowP[14])){$value=0;}else{$value=$rowP[14];echo $value;}?>" >
                    <div align="center" id='submit' class='outerDiv'>
                    <input type="submit" name="submit" value="Guardar" onclik="" />
                    <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/principal.php'"/>  
                    <div class='clearfix'></div>
                    </div>
                    </form>
    </div>
 </body>
<script type="text/javascript">
            
            function Cancelar(){
             
            location.href("http://aplicaciones.intn.gov.py/web/phpsueldos2016/principal.php")
    }
</script>

 
</html>
       