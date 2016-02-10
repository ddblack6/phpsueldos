
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
        <title>Descuentos Judiciales</title>
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
        //no read only Judicial
        function noReadOnlyJudicial(){
            var campo = document.getElementById('inputJudicial');
            campo.readOnly = false; // Se añade el atributo
        }
        //se calcula el descuento judicial
        function  DescuentoJudicial(){     
             //obtiene el valor anterior de sal_jud
            var sal_jud=document.getElementById("sal_jud").value
             //valor del input de sueldo neto
            var SaldoNeto= document.getElementById('sueldoNeto').value;
            //si anteriormente ya tenia un valor restaura ante cambios del operador
             if(sal_jud > 0)
                 {
                 var suma=parseFloat(SaldoNeto) + parseFloat(sal_jud);
                 document.getElementById("sueldoNeto").value=suma;
                }
                //valor del input del descuento judicial
             var monto= document.getElementById('inputJudicial').value;
             //el nuevo valor de Saldo Neto
             var SaldoNeto= document.getElementById("sueldoNeto").value;
             document.getElementById("sueldoNeto").value=(SaldoNeto-monto);
             document.getElementById("sal_jud").value=monto;
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
                 <caption>Descuentos Judiciales</caption>  
                 <th> Judiciales </th>
                        <tr>
                            <td>
                            <fieldset>
                            <legend align= "left">Descuentos Judiciales</legend>
                             <label for="txtCI">Descontar</label> <input type=radio name="judicial" onclick="noReadOnlyJudicial()" value=1>
                             <div class='clearfix'></div>
                             <label for="txtCI">No descontar</label><input type=radio name="judicial" value=0 onclick="Refrescar()" checked>
                             <div class='clearfix'></div>
                           <label for="txtCI">Monto:</label><INPUT type="numeric" onchange=" DescuentoJudicial()" id="inputJudicial" value="<?php if(empty ($rowP[11])){$value=0;}else{$value=$rowP[11];echo $value;}?>" name="txtDescuentoJudicial" onKeypress="if ((event.keyCode < 45 || event.keyCode > 57)  && (event.keyCode != 13)) event.returnValue = false;" readonly="true"><BR>
                            </fieldset>
                            </td>
                            </tr>
                         </table>
            <div id='name' class='outerDiv'>
                    <div class='clearfix'></div>
            </div>
                    <form action="clases/ClsSalario.php?nuevo=4" method="post" onClik="submit" >
                    <input type="hidden" name="Nfun_cod" value="<?php if(empty ($rowP[6])){$value=0;}else{$value=$rowP[6];echo $value;}?>"/> 
                    <input type="hidden" id="sal_cod" name="Nsal_cod"  value="<?php if(empty ($codigo)){$value=0;}else{$value=$codigo;echo $value;}?>" >
                    <input type="hidden" id="sal_jud" name="Nsal_jud">
                    <input type="hidden" id="sal_neto" name="Nsal_neto" value="<?php if(empty ($rowP[14])){$value=0;}else{$value=$rowP[14];echo $value;}?>" >
                    <div align="center" id='submit' class='outerDiv'>
                    <input type="submit" name="submit" value="Guardar" onclik="" />
                    <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://192.168.0.99/web/phpsueldos2015/userloget/principal.php'"/>  
                    <div class='clearfix'></div>
                    </div>
                    </form>
    </div>
 </body>
<script type="text/javascript">
            
            function Cancelar(){
             
            location.href("http://192.168.0.99/web/phpsueldos2015/principal.php")
    }
</script>

 
</html>
       