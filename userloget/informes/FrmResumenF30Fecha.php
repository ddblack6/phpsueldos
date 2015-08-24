 <!DOCTYPE html>
<html>
    
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Resumen Fuente 30-Fecha</title>
        <link href="../Site.css" rel="stylesheet">
        <link href="../tabla.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
                <link rel="stylesheet" href="../twitter-signup.css" type="text/css" />
  
    </head>
     <?php include("../principal.php"); ?>
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
       

               <div class='clearfix'></div>
                    <div id="twitter">
                        <FORM action="InformeSueldoResumenF30Fecha.php" method="post">
                            <div class='clearfix'></div>
                             <div id='name' class='outerDiv'>    
                            <label for="txtFecha"> Fecha</label> 
                            <input type="date" name="txtFecha" id="fechaPagoHasta" required />
                            </div>
                             <div class='clearfix'></div>
                            <input type="submit" name="submit" value="Generar" />
                            <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldosuserloget/principal.php'"/>  
                    
                            
                            <div class='clearfix'></div>
                         </form>  
                    
    </div>
 </body>


 
 
</html>
