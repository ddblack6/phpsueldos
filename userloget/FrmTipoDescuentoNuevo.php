
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
        <title>Tipo Descuentos</title>
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
                 		<form autocomplete="off" action="clases/ClsTipoDescuento.php?nuevo=1" method="post"> 
						
                                                <div id='name' class='outerDiv'>
							<label for="txtDescuentos">Descripción:</label> 
							<input type="text" name="txtDescuentos" required  /> 
							<div class='message' id='nameDiv'> Ingrese decripción </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                               <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldos/userloget/principal.php'"/>   
                                                </div>
                                                
				</form>
                        
                                        
                                        <div class='clearfix'></div>
					</br></br></br></br>
                    </div>
        
                    <div class="centerTable">
             <?php 
                 
                   include './funciones.php';
                        //hace una conexion local
                        conexionlocal();
                        $result = pg_query("SELECT row_number()over (partition by 0 order by tde_cod) as   lineas, tde_cod,tde_des FROM tipo_descuento order by tde_cod"); 
                    if ($row = pg_fetch_array($result)){
                       echo "<table style='margin: 30 auto;' heigth=100% width=50% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3'> \n"; 
                      echo " <caption>Tipos Descuentos (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>Descripción</th> \n"; 
                       do { 
                          echo "<tr><td>".$row["lineas"]."</td><td>".$row["tde_cod"]."</td><td>".$row["tde_des"]."</td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n";
                        echo "</br/br/br>";
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
