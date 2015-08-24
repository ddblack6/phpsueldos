
<!DOCTYPE html>
<html>
    <!--
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */
-->
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cargos</title>
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
                 		<form autocomplete="off" action="clases/ClsCargo.php?nuevo=1" method="post"> 
						<div id='name' class='outerDiv'>
							<label for="txtdescripcion">Descripción:</label> 
							<input type="text" name="txtdescripcion" required  /> 
							<div class='message' id='nameDiv'> ingrese cargo </div>
						</div>
                                                <div class='clearfix'></div>
                                                 <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                               <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldosuserloget/principal.php'"/>   
                                                </div>
                                                
                               </form>
                            <div class='clearfix'></div>
                            </br></br></br></br></br>
		</div>
        <div class="centerTable">
             <?php 
                 
                   include './funciones.php';
                        //hace una conexion local
                        conexionlocal();
                        $result = pg_query("SELECT row_number()over (partition by 0 order by car_cod) as   lineas, car_cod,car_des FROM cargo order by car_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=50% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3'> \n"; 
                        echo " <caption>Cargos (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Líneas</th><th>Código</th><th>Descripción</th > \n"; 
                       do { 
                          echo "<tr><td>".$row["lineas"]."</td><td>".$row["car_cod"]."</td><td>".$row["car_des"]."</td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                        echo "</br>";
                    } else { 
                        echo "<p align=center>";
                        echo "¡ No se ha encontrado ningún registro !"; 
                        echo "</p>";
                    } 
                    ?> 
        </div>
 
       
       </div>
       <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
</html>
