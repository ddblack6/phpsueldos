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
        //se calcula los descuentos por AUSENCIA
        /*
        function DescuentoAusencia(){
            //recupero el valor de ausencia
            var sal_aus= document.getElementById("sal_aus").value;
            var SaldoNeto= document.getElementById('sueldoNeto').value;
            var SueldoBrutoIni=document.getElementById('sueldoBruto').value;
            var jornal=SueldoBrutoIni/30;
            var IPSanterior=document.getElementById("sal_ips").value;
            var dias=document.getElementById('DiaAusencia').value;
            //reestablece los valores al cambiar dias
             if(sal_aus > 0)
              {
              var suma=parseFloat(SaldoNeto) + parseFloat(sal_aus);
              document.getElementById("sueldoNeto").value=suma;
              //reiniciamos el valor de IPS
              document.getElementById("sal_ips").value=(SueldoBrutoIni*9)/100;
              //despliega el IPS que debe mostrar
              document.getElementById("IPSMONTO").value=(SueldoBrutoIni*9)/100;
              }
               //reestablece sueldo Neto
              document.getElementById("sueldoNeto").value= parseFloat(SaldoNeto) + parseFloat(IPSanterior);
              var sueldoNetoRees=document.getElementById("sueldoNeto").value;
              //obtiene la cantidad de dias
              var dias=document.getElementById('DiaAusencia').value;
              //calcula jornal diario por cantidad de dias
              document.getElementById("sal_aus").value=jornal*dias;
              var descuento=document.getElementById("sal_aus").value;
              //una vez que haya calculado el descuento, calcula el nuevo IPS
              var SueldoDescuento=sueldoNetoRees-descuento;
              document.getElementById("sueldoNeto").value=SueldoDescuento;
              var nuevoIPS=(SueldoDescuento*9)/100;
              document.getElementById("sal_ips").value=nuevoIPS;
              document.getElementById("IPSMONTO").value=nuevoIPS;
              //se termino de calcular el nuevo IPS
             //ahora calculamos el nuevo sueldo neto restando el nuevo IPS
             var SN=document.getElementById("sueldoNeto").value;
             document.getElementById('sueldoNeto').value=parseFloat(SN)-parseFloat(nuevoIPS);
             //fin del algoritmo..
        }
        */
       function DescuentoAusencia(){
            var SueldoNeto= document.getElementById('sueldoNeto').value;
            var ipsanterior=document.getElementById("sal_ips").value
            SueldoNeto=parseFloat(SueldoNeto)+parseFloat(ipsanterior);
            document.getElementById("sueldoNeto").value=SueldoNeto;
            var dias=document.getElementById('DiaAusencia').value;
            var SueldoBrutoIni=document.getElementById('sueldoBruto').value;
            var jornal=Math.round(SueldoBrutoIni/30);
            document.getElementById("sal_aus").value=jornal*dias;
            
            var sal_aus= document.getElementById("sal_aus").value;
            var sueldodescontado=SueldoBrutoIni-sal_aus;
            document.getElementById("sal_ips").value=Math.round((sueldodescontado*9)/100);
            document.getElementById("IPSMONTO").value=Math.round((sueldodescontado*9)/100);
            
            var ipsaux=document.getElementById("IPSMONTO").value;
            document.getElementById("sueldoNeto").value=parseFloat(SueldoNeto)-ipsaux-(jornal*dias);
             document.getElementById("sal_neto").value=parseFloat(SueldoNeto)-ipsaux-(jornal*dias);
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
                      <caption>Ausencias, Permisos y Llegadas Tardías </caption>  
                         <th>IPS</th><th> Ausencias</th> 
                        <tr>
                           <td>
                           <fieldset>
                           <legend align= "left">MONTO IPS  </legend>
                           <INPUT type="numeric"  id="IPSMONTO" name="txtIPSMonto" readonly="true" value="<?php if(empty ($rowP[8])){$value=0;}else{$value=$rowP[8];echo $value;}?>"><BR>
                           <div class='clearfix'></div>
                           </fieldset>
                           </td>
                           <td>
                           <input type=radio  name="ausen" value=1>Descontar <br>
                           <input type=radio  name="ausen" onclick="Refrescar()" value=0 checked>No descontar<br>
                          
                           <?php
                            echo "<select name='Ausencia' onchange='DescuentoAusencia()' id='DiaAusencia'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            
                            </td>
                            </tr>
            </table>
              
            <div id='name' class='outerDiv'>
                    <div class='clearfix'></div>
            </div>
                    <form action="clases/ClsSalario.php?nuevo=6" method="post" onClik="submit" >
                    <input type="hidden" name="Nfun_cod" value="<?php if(empty ($rowP[6])){$value=0;}else{$value=$rowP[6];echo $value;}?>"/> 
                    <input type="hidden" id="sal_ips" name="Nsal_ips" value="<?php if(empty ($rowP[8])){$value=0;}else{$value=$rowP[8];echo $value;}?>">
                    <input type="hidden" id="sal_cod" name="Nsal_cod"  value="<?php if(empty ($codigo)){$value=0;}else{$value=$codigo;echo $value;}?>" >
                    <input type="hidden" id="sal_aus" name="Nsal_aus" >
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
       