
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
        <!//<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
        <link rel="stylesheet" href="twitter-signup.css" type="text/css" />

         <link href="../tabla.css" rel="stylesheet">
        <script type="text/javascript">
            var variablejs;
        function Modificar(codigo) {
           
           //paso este dato a mi php
                document.cookie ='var='+codigo; 
                document.cookie =0;
    }
        function Refrescar(){
            
           location.reload()
        }
        function Cancelar(){
             
            location.href("http://aplicaciones.intn.gov.py/web/phpsueldos2016/principal.php")
        }
        function checkEstado(form){
              if (form.checksituacion=='t')
                {
                form.checksituacion.checked = true;
                }
                if (form.checkjubilado=='t')
                {
                form.checksituacion.checked = true;
                }
         }  
     function Fuente(){
        
             var radio10= document.getElementById('radio10').value;
           
             if (radio10=='1'){
                  document.getElementById("txtRadioFuente").value=1;
             }
             else{
                  document.getElementById("txtRadioFuente").value=0;
             }
            
        }            
     
    </script>
<?php
 if  (empty($_COOKIE["var"])){
     $codigo=0;    
 }  else
 {
     $codigo = $_COOKIE["var"];
     setcookie("var", $_COOKIE["var"], time()+12);
 }

//recibo el codigo y hago el query
include './funciones.php';
 conexionlocal();
$result = pg_query("SELECT fun_cod,car_cod,fun_ficha,fun_ci,fun_nom,fun_ape,fun_sit,fun_jdt,fun_fuente FROM funcionario where fun_cod= ".$codigo); 
$row = pg_fetch_array($result);

?>
    </head>
    <body>
         <?php include("principal.php");?>
        <div id="twitter">
    
        <div class='clearfix'></div>
        

                    <div id="twitter">
                        <form autocomplete="off" action="clases/ClsFuncionario.php?nuevo=2" method="post" onClik="submit"> 
                                                        <div id='name' class='outerDiv'>
							<input type="hidden" name="txtcodigo" value="<?php echo $row['fun_cod'];?>" required  /> 
							<div class='message' id='nameDiv'></div>
                                                         </div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtCargo">Cargo</label> 
                                                        <select name="txtCargo2" itemid="<?php echo $row['car_cod'];?>" required>
                                                            <option selected>
                                                            <?php
                                                            $query1 = "Select car_cod ,car_des from cargo";
                                                            $resultadoSelect = pg_query($query1);

                                                            while ($row2 = pg_fetch_row($resultadoSelect)) {
                                                            echo "<option value=".$row2[0].">";
                                                            echo $row2[1];
                                                            echo "</option>";
                                                              }


                                                             ?>
                                                          </select>
                                                         </div>
                                                        <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtCI">Nº CI:</label> 
							<input type="text" name="txtCI" value="<?php echo $row['fun_ci'];?>" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de CI </div>
                                                        </div>
                                                         <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtCI">Nº Ficha:</label> 
							<input type="text" name="txtNroFicha" value="<?php echo $row['fun_ficha'];?>" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de CI </div>
                                                        </div>
                                                        <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtNombre">Nombre:</label> 
							<input type="text" name="txtNombre" value="<?php echo $row['fun_nom'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese Nombre </div>
                                                        </div>
                                                        <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtApellido">Apellido:</label> 
							<input type="text" name="txtApellido" value="<?php echo $row['fun_ape'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese Apellido </div>
                                                        </div>
						<div class='clearfix'></div>
						<div id='password' class='outerDiv'>
							<label for="checksituacion">Activo:</label> 
                                                        <input type="checkbox" name="checksituacion" onclick="checkEstado(this.form)" value="<?php echo $row['fun_sit'];?>"/> 
							<div class='message' id='websiteDiv'> activo? </div>
						</div>
						<div class='clearfix'></div>
						<div id='email' class='outerDiv'>
							<label for="checkjubilado">Jubilado:</label> 
							<input type="checkbox" name="checkjubilado" onclick="checkEstado(this.form)" value="<?php echo $row['fun_jdt'];?>" /> 
							<div class='message' id='emailDiv'> jubilado? </div>
						</div>
						<div class='clearfix'></div>
						<div id='email' class='outerDiv'>
							<label for="checkjubilado">Fuente:</label> 
							 <input type=radio  onclick="Fuente()"  id="radio10" value="1" name="fuente">Fuente 10<br>
                                                         <input type=radio name="fuente" id="radio20" value=0  >Fuente 30<br>
                                                         <input type="hidden" id="txtRadioFuente"name="txtRadioFuente">
						</div>
						<div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                                <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/principal.php'"/>  
                                                </div>
                                                <div class='clearfix'></div>
                            </form>       
                          <div class='clearfix'></div>
                            </div>
        <div class='clearfix'></div>
        <div class="centerTable" >
             <?php 
                  
                  // include './funciones.php';
                   //hace una conexion local
                     // conexionlocal();
                     $result = pg_query("SELECT row_number()over (partition by 0 order by f.fun_cod) as   lineas, f.fun_cod,f.fun_ficha,fun_fuente,f.car_cod,c.car_des,f.fun_ci,f.fun_nom,f.fun_ape,f.fun_sit,f.fun_jdt FROM funcionario f, cargo c  where f.car_cod=c.car_cod order by fun_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                       echo " <caption>Modificar Funcionarios (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Cargo</th><th>C.I. Nº</th><th>Nombre</th><th>Apellido</th><th>Activo</th><th>Jubilado</th><th>Fuente</th><th>Modificar</th>\n"; 
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
                       echo "<tr><td>".$row["lineas"]."</td><td>".$row["fun_cod"]."</td><td>".$row["car_des"]."</td><td>".$row["fun_ci"]."</td><td>".$row["fun_nom"]."</td><td>".$row["fun_ape"]."</td><td>".$Activo."</td><td>".$Jubilado."</td><td>".$Fuente."</td><td><span class='editar' value='".$row["fun_cod"]."' , OnClick='Modificar(".$row["fun_cod"].");'>Editar</span></td></tr> \n"; 
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
        </div>
   <div class='clearfix'></div>
   </div>
<a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
    
    
</html>
