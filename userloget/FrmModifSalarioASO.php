
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
        <title>Descuento ASO</title>
        <link href="../Site.css" rel="stylesheet">
        <link href="../tabla.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
		<link rel="stylesheet" href="twitter-signup.css" type="text/css" />
                
                
        <script>
            
        function DescuentoASO(){
           
            var sal_aso=document.getElementById("sal_aso").value
            
            var SaldoNeto= document.getElementById('sueldoNeto').value;
           
             if(sal_aso > 0)
                 {
                 var suma=parseFloat(SaldoNeto) + parseFloat(sal_aso);
                 document.getElementById("sueldoNeto").value=suma;
                }
              
             var monto= document.getElementById('InputASO').value;
             
             var SaldoNeto= document.getElementById("sueldoNeto").value;
             document.getElementById("sueldoNeto").value=(SaldoNeto-monto);
             document.getElementById("sal_aso").value=monto;
             
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
             CAT.cat_nom--16
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
                 <caption>Descuentos</caption>  
                 <th> Asociación INTN </th>
                        <tr>
                            <td>
                            <fieldset>
                            <legend align= "left">Asociación INTN</legend>
                            <div>
                             <label for="txtSueldoNeto">Monto:</label> 
                            <INPUT type="numeric" onchange="DescuentoASO()" value="<?php if(empty ($rowP[12])){$value=0;}else{$value=$rowP[12];echo $value;}?>" id="InputASO" name="montoaso" onKeypress="if ((event.keyCode < 45 || event.keyCode > 57) && (event.keyCode != 13)) event.returnValue = false;">
                            </div></fieldset>
                            </td>
        </table>                
                    <form action="clases/ClsSalario.php?nuevo=2" method="post" onClik="submit" >
                    <input type="hidden" name="Nsal_cod" value="<?php if(empty ($rowP[4])){$value=0;}else{$value=$rowP[4];echo$value;}?>"/> 
                    <input type="hidden" name="Nfun_cod" value="<?php if(empty ($rowP[0])){$value=0;}else{$value=$rowP[0];echo$value;}?>"/>
                    <input type="hidden" id="sal_pyt" name="Nsal_pyt20" value="<?php if(empty ($rowP[17])){$value=0;}else{$value=$rowP[17];echo$value;}?>"/> 
                    <input type="hidden" id="sal_aso" name="Nsal_aso" value="<?php if(empty ($rowP[12])){$value=0;}else{$value=$rowP[12];echo$value;}?>"/> 
                    <input type="hidden" id="sal_neto" name="Nsal_neto" value="<?php if(empty ($rowP[14])){$value=0;}else{$value=$rowP[14];echo$value;}?>"/>  
                    <div align="center" id='submit' class='outerDiv'>
                    <input type="submit" name="submit" value="Guardar" onclik="" />
                    <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldos/userloget/principal.php'"/>  
                    <div class='clearfix'></div>
                    </div>
                    </form>
         </div>
        
        
    </body>
</html>