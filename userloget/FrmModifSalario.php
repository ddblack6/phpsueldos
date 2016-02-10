
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
        function RedirigirASO(){
            window.location='http://192.168.0.99/web/phpsueldos2015/userloget/FrmModifSalarioASO.php';
        }
        function RedirigirIPS(){
            window.location='http://192.168.0.99/web/phpsueldos2015/userloget/FrmModifSalarioIPS.php';
        }
        function RedirigirJUD(){
            window.location='http://192.168.0.99/web/phpsueldos2015/userloget/FrmModifSalarioJUD.php';
        }
        function RedirigirREP(){
            window.location='http://192.168.0.99/web/phpsueldos2015/userloget/FrmModifSalarioREP.php';
        }
        function RedirigirAUS(){
            window.location='http://192.168.0.99/web/phpsueldos2015/userloget/FrmModifSalarioAUS.php';
        }
         function RedirigirPYT(){
            window.location='http://192.168.0.99/web/phpsueldos2015/userloget/FrmModifSalarioPYT.php';
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
             $_COOKIE["varMod"]=0;
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
                     
                   <table> <caption>Seleccione un Descuento </caption>  </table>
                    <form>
                    <div id='name' class='outerDiv'>
                    <input type="button" name="cancel" value="Ausencias" onclick="RedirigirAUS()"/>  
                    </div>
                    <div class='clearfix'></div>
                    
                    <div id='name' class='outerDiv'>
                    <input type="button" name="cancel" value="IPS" onclick="RedirigirIPS()"/>  
                    </div>
                    <div class='clearfix'></div>
                    
                    <div id='name' class='outerDiv'>
                    <input type="button" name="cancel" value="ASO" onclick="RedirigirASO()"/>  
                    </div>
                     <div class='clearfix'></div>
                     <div id='name' class='outerDiv'>
                    <input type="button" name="cancel" value="Permisos y Tardias" onclick="RedirigirPYT()"/>  
                    </div>
                     <div class='clearfix'></div>
                     
                     <div id='name' class='outerDiv'>
                    <input type="button" name="cancel" value="Reposo" onclick="RedirigirREP()"/>  
                    </div>
                     <div class='clearfix'></div>
                     
                     <div id='name' class='outerDiv'>
                    <input type="button" name="cancel" value="Judiciales" onclick="RedirigirJUD()"/>  
                    </div>
                     <div class='clearfix'></div>
                     
                    </form>
    </div>
 <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
<script type="text/javascript">
            
            function Cancelar(){
             
            location.href("http://192.168.0.99/web/phpsueldos2015/principal.php")
    }
</script>
</html>
       