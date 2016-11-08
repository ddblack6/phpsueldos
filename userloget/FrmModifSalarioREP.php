 
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
        <title>Descuentos Reposo</title>
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
        
        //calcular descuento reposo
        //calculamos el descuento de reposo//50% descuenta INTN y 50% IPS
        //estos valores pueden variar en dias y horas..se paga mitad y mitad.
        function DescuentoReposo(){
			//HASTA ACA SE ACTUALIZO CARGANDO EL IPS ANTERIOR
             //recuperamos el valor descuento reposo anterior
             var descuentoReposo=document.getElementById("sal_repaux").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
			 //recuperamos el sueldo bruto
			 var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
			 	  //calculamos el ips antiguo
			var ipsantiguo=parseInt(SaldoBrutoIni*9/100);
		
			 //calcula el jpornal diario
            var jornal=parseInt(SaldoBrutoIni/30);
			//restaurar con el ips anterior..se debe sumar
			var actualizarneto=parseInt(SueldoNeto) + parseInt(ipsantiguo);
			
			document.getElementById("sueldoNeto").value=actualizarneto;
		
			//-------------------------------------------------------------------------------
			
			 //ACA SE CALCULO LOS DESCUENTOS
			
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('DiaReposo').value;
             //descuento por dia de 50 %
             var descuentoINTN=(jornal/2);
             document.getElementById("sal_rep").value=parseInt(descuentoINTN*dias);
			var descuentototaldias=parseInt(descuentoINTN*dias);
			
		
			 //---------------------DESCONTAMOS EL MONTO POR REPOSO---------------------------------
             var sueldoneto= document.getElementById('sueldoNeto').value;
			
             document.getElementById("sueldoNeto").value=(sueldoneto - descuentototaldias);
			 
			 //---------------------CALCULAMOS EL NUEVO IPS----------------------------------------------
             
			
			var netoparaIPS=SaldoBrutoIni -descuentototaldias;
			var ipsnuevo=parseInt((netoparaIPS*9)/100);
			document.getElementById("Nsal_ips_rep").value=ipsnuevo;
			
			//------------------------RESTAMOS EL NETO ACTUAL EL NUEVO IPS----------------------------------------------
			var neto=document.getElementById("sueldoNeto").value;
			var mostrarNeto=neto-ipsnuevo;
			document.getElementById("sueldoNeto").value=mostrarNeto;
			//de la base de datos
			document.getElementById("sal_neto").value=(mostrarNeto);
			
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
                 <caption>Descuentos Varios</caption>  
                 <th> Reposo </th>
                        <tr>
                        <td>
                            <fieldset>
                            <legend align= "left">Reposo</legend>
                           <label for="txtSueldoNeto">Descontar</label>  <input type=radio  name="reposo" value=1> <br>
                            <div class='clearfix'></div>
                           <label for="txtSueldoNeto">No descontar</label>  <input type=radio  name="reposo" onclick="Refrescar()" value=0 checked><br>
                            <div class='clearfix'></div>
                           <?php
                            echo "<select name='Reposo' onchange='DescuentoReposo()' id='DiaReposo'>";
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
            <div id='name' class='outerDiv'>
                    <div class='clearfix'></div>
            </div>
                    <form action="clases/ClsSalario.php?nuevo=5" method="post" onClik="submit" >
                    <input type="hidden" name="Nfun_cod" value="<?php if(empty ($rowP[6])){$value=0;}else{$value=$rowP[6];echo $value;}?>"/>
                    <input type="hidden" name="Nsal_cod" value="<?php if(empty ($rowP[4])){$value=0;}else{$value=$rowP[4];echo$value;}?>"/> 
                    <input type="hidden" id="sal_repaux" name="Nsal_repaux" value="<?php if(empty ($rowP[13])){$value=0;}else{$value=$rowP[13];echo $value;}?>"/>
                    <input type="hidden" id="sal_rep" name="Nsal_rep"/>
                    <input type="hidden" id="sal_neto" name="Nsal_neto" value="<?php if(empty ($rowP[14])){$value=0;}else{$value=$rowP[14];echo $value;}?>" >
					<input type="hidden" name="Nsal_ips_rep" id="Nsal_ips_rep"/> 
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
       