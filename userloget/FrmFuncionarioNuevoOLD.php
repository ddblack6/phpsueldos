
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
       
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
		<link rel="stylesheet" href="twitter-signup.css" type="text/css" />

                 <link href="../tabla.css" rel="stylesheet">
                 
     <script>
     function Fuente(){
        
             var radio10= document.getElementById('radio10').value;
             if (radio10=='1'){
                  document.getElementById("txtRadioFuente").value=radio10;
             }
             else{
                  document.getElementById("txtRadioFuente").value=0;
             }

        }            
     </script>
                    
                 
    </head>
    <body>
         <?php include("principal.php"); ?>
        <div id="twitter">
    
       
        <div class='clearfix'></div>
        
                    <div id="twitter">
                 		<form autocomplete="off" action="clases/ClsFuncionario.php?nuevo=1" method="post"> 
                                                        <div id='name' class='outerDiv'>
							<label for="txtCargo">Cargo</label> 
                                                        <select name="txtCargo2"  required>
                                                            <option selected>
                                                            <?php
                                                            include './funciones.php';    
                                                            conexionlocal();
                                                            $query = "Select car_cod ,car_des from cargo";
                                                            $resultadoSelect = pg_query($query);

                                                            while ($row = pg_fetch_row($resultadoSelect)) {
                                                            echo "<option value=".$row[0].">";
                                                            echo $row[1];
                                                            echo "</option>";
                                                              }


                                                             ?>
                                                          </select>
                                                         </div>
                                                        <div class='message' id='nameDiv'> Ingrese cargo </div>
                                                        <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtCI">CI Nº</label> 
							<input type="text" name="txtCI" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required  /> 
							<div class='message' id='nameDiv'> Ingrese ci </div>
                                                        <div class='clearfix'></div>
						</div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtNroFicha">Nº Ficha</label> 
							<input type="text" name="txtNroFicha" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de ficha </div>
                                                        </div>
                                                <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtNombre">Nombre:</label> 
							<input type="text" name="txtNombre" required  /> 
							<div class='message' id='nameDiv'> Ingrese nombre </div>
						</div>
						<div class='clearfix'></div>
						<div id='username' class='outerDiv'>
							<label for="txtApellido">Apellido:</label> 
							<input type="text" name="txtApellido" required  /> 
							<div class='message' id='usernameDiv'> Ingrese apellido </div>
						</div>
						<div class='clearfix'></div>
						<div id='password' class='outerDiv'>
							<label for="checksituacion">Activo:</label> 
							<input type="checkbox" name="checksituacion"/> 
							<div class='message' id='websiteDiv'> situación funcionario. </div>
						</div>
						<div class='clearfix'></div>
						<div id='email' class='outerDiv'>
							<label for="checkjubilado">Jubilado:</label> 
							<input type="checkbox" name="checkjubilado" /> 
							<div class='message' id='emailDiv'> situación Jubilado </div>
						</div>
                                                <div class='clearfix'></div>
						<div id='email' class='outerDiv'>
							<label for="checkjubilado">Fuente:</label> 
							 <input type=radio  onclick="Fuente()" id="radio10" name="fuente" value=1>Fuente 10<br>
                                                         <input type=radio name="fuente" id="radio20" value=0  >Fuente 30<br>
                                                         <input type="hidden" id="txtRadioFuente"name="txtRadioFuente">
						</div>
						<div class='clearfix'></div>
						
						<div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                               <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/principal.php'"/>  
                                                </div>
					</form>
                                       
                                        <div class='clearfix'></div>
		</div>
                <div class="centerTable">
             <?php 
                 
                  
                        //hace una conexion local
                        
                        $result = pg_query("SELECT row_number()over (partition by 0 order by f.fun_cod) as   lineas, f.fun_cod,f.fun_ficha,f.fun_fuente,f.car_cod,c.car_des,f.fun_ci,f.fun_nom,f.fun_ape,f.fun_sit,f.fun_jdt FROM funcionario f, cargo c  where f.car_cod=c.car_cod order by fun_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3'> \n"; 
                       echo " <caption>Funcionarios (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Ficha</th><th>Cargo</th><th>CI Nº</th><th>Nombre</th><th>Apellido</th><th>Activo</th><th>Jubilado</th><th>Fuente</th> \n"; 
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
                           
                          echo "<tr><td>".$row["lineas"]."</td><td>".$row["fun_cod"]."</td><td>".$row["fun_ficha"]."</td><td>".$row["car_des"]."</td><td>".$row["fun_ci"]."</td><td>".$row["fun_nom"]."</td><td>".$row["fun_ape"]."</td><td>".$Activo."</td><td>".$Jubilado."</td><td>".$Fuente."</td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                        echo "</br>";
                    } else { 
                   echo "<p align=center>";
                   echo "¡ No se ha encontrado ningún registro !"; 
                   echo "</p>";
                    } 
                    ?> 
                    </br></br></br></br>
                </div>
       
      </div>     
    </body>
<a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
</html>
