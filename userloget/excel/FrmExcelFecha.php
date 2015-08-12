<!DOCTYPE html>
<html>
    
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Excel-Fechas</title>
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
     function Fuente(){
        
             var radio10= document.getElementById('radio10').value;
             if (radio10=='1'){
                  document.getElementById("txtRadioFuente").value=radio10;
             }
             else{
                  document.getElementById("txtRadioFuente").value=0;
             }

        }
        
          function Nombre(){
           var s = document.Form.txtNombreOrganismo;
           var nombre=s.options[s.selectedIndex].text;
            document.cookie ='Organismo='+nombre; 
            document.cookie =0;
        }
        
</script>
        <?php include("../principal.php"); ?>

               <div class='clearfix'></div>
                    <div id="twitter">
                        <FORM name="Form" action='InformeExcelFecha.php' method="post">
                            <div class='clearfix'></div>
                            <div id='name' class='outerDiv'>    
                            <label for="txtFecha">Fecha</label> 
                            <input type="date" name="txtFecha" id="fechaPagoDesde" required/>
                            </div>
                            <div class='clearfix'></div>
                            <div id='radios' class='outerDiv'>
				<label for="checkjubilado">Fuente:</label>
                                <div class='clearfix'></div>
                                <input type=radio  onclick="Fuente()" id="radio10" name="fuente" value=1>Fuente 10
                                <div class='clearfix'></div>
                                <input type=radio name="fuente" id="radio20" value=2  >Fuente 30
                                <div class='clearfix'></div>
                                <input type=radio name="fuente" id="todos" value=3  >Todos
                                <div class='clearfix'></div>
                            </div>
                            <div class='clearfix'></div>
                            <div class='outerDiv'>
                            <input type="submit" name="submit" value="Generar" />
                            <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldos/userloget/principal.php'"/>  
                            </div>
                            
                         </form>  
                    
    </div>
 </body>


 
 
</html>
