
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
       
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
		<link rel="stylesheet" href="twitter-signup.css" type="text/css" />
                 <link href="../tabla.css" rel="stylesheet">
    </head>
    <body>
         <?php include("principal.php"); ?>
        <div id="twitter">
       
        <div class='clearfix'></div>
        
                    <div id="twitter">
                 		<form autocomplete="off" action="clases/ClsOrganismoDetalle.php?nuevo=1" method="post"> 
                                                        <div id='name' class='outerDiv'>
							<label for="txtOrganismo">Organismo:</label> 
                                                        <select name="txtOrganismo"  required>
                                                            <option selected>
                                                            <?php
                                                            include './funciones.php';    
                                                            conexionlocal();
                                                            $query = "Select org_cod ,org_des from organismo";
                                                            $resultadoSelect = pg_query($query);

                                                            while ($row = pg_fetch_row($resultadoSelect)) {
                                                            echo "<option value=".$row[0].">";
                                                            echo $row[1];
                                                            echo "</option>";
                                                              }
                                                             ?>
                                                          </select>
                                                         </div>
                                                        <div class='message' id='nameDiv'> Ingrese organismo </div>
                                                        <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtFuncionario">Funcionario:</label> 
                                                        <select name="txtFuncionario"  required>
                                                            <option selected>
                                                            <?php
                                                            $query = "Select fun_cod,concat(fun_nom,' ',fun_ape) as fun_nom from funcionario order by fun_nom";
                                                            $resultadoSelect = pg_query($query);

                                                            while ($row2 = pg_fetch_row($resultadoSelect)) {
                                                            echo "<option value=".$row2[0].">";
                                                            echo $row2[1];
                                                            echo "</option>";
                                                              }
                                                             ?>
                                                          </select>
                                                         </div>
                                                        <div class='message' id='nameDiv'> Ingrese Funcionario </div>
                                                        <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtFecha">Fecha:</label> 
							<input type="date" name="txtFecha" required  /> 
							<div class='message' id='nameDiv'> Ingrese fecha </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                                <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://192.168.56.100/web/phpsueldos/userloget/principal.php'"/>  
                                                </div>
					</form>
                                       
                                        <div class='clearfix'></div>
		</div>
                <div class="centerTable">
             <?php 
                 
                  
                        //hace una conexion local
                        
                        $result = pg_query("SELECT row_number()over (partition by 0 order by FUNC.fun_cod) as   lineas, FUNC.fun_cod,ORG.org_des,FUNC.fun_ci,FUNC.fun_nom,FUNC.fun_ape,to_char(ORGDET.ord_fec,'DD/MM/YYYY')  as ord_fec FROM funcionario FUNC, organismo_detalle ORGDET,organismo ORG  where FUNC.fun_cod=ORGDET.fun_cod and ORGDET.org_cod=ORG.org_cod order by FUN_COD"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3'> \n"; 
                       echo " <caption>Organismos Detalles (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Organismo</th><th>CI Nº</th><th>Nombre</th><th>Apellido</th><th>Fecha Categoría</th> \n"; 
                       do {
                          echo "<tr><td>".$row["lineas"]."</td><td>".$row["fun_cod"]."</td><td>".$row["org_des"]."</td><td>".$row["fun_ci"]."</td><td>".$row["fun_nom"]."</td><td>".$row["fun_ape"]."</td><td>".$row["ord_fec"]."</td></tr> \n"; 
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
    <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
</html>
