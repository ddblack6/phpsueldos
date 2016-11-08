<!DOCTYPE html>
<html>
    
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Resumen-Funcionario</title>
        <link href="../Site.css" rel="stylesheet">
        <link href="../tabla.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
                <link rel="stylesheet" href="../twitter-signup.css" type="text/css" />
    </head>
    <body>
        <script>  
         function Refrescar(){
           location.reload();
        }
        //para agregar una linea en mi tabla
    
        //para borrar un registro de mi tabla
       
        function ActualizaInput(){
            document.getElementById("cinConfirm").value = " ";
           
        }
      
        
      
     
</script>
        <?php include("../principal.php"); ?>

               <div class='clearfix'></div>
                    <div id="twitter">
                        <FORM action="InformeOrganismos.php" method="post">
                            <div class='clearfix'></div>
                          <div id='name' class='outerDiv'>
							<label for="txtOrganismo">Organismo:</label> 
                                                        <select name="txtOrganismo"  required>
                                                            <option selected>
                                                            <?php
                                                            include '../funciones.php';    
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
                            <div class='clearfix'></div>
                            <div class='outerDiv'>
                            <input type="submit" name="submit" value="Generar" />
                            <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://aplicaciones.intn.gov.py/web/phpsueldos2016/userloget/principal.php'"/>  
                            </div>
                            
                         </form>  
                    
    </div>
 </body>


 
 
</html>
