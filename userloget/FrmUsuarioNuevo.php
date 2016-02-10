
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
        <title>Usuarios</title>
        <link href="../Site.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
        <link rel="stylesheet" href="twitter-signup.css" type="text/css" />
        <link href="../tabla.css" rel="stylesheet">

<script language="JavaScript">
//Código para colocar 
//los indicadores de miles mientras se escribe
//script por tunait!
	
</script>
         
    </head>
    <body>
     <?php include("principal.php");?>
     <div id="twitter">
        <div class='clearfix'></div>
                    <div id="twitter">
                 		<form autocomplete="off" action="clases/ClsUsuario.php?nuevo=1" method="post" onClik="submit"> 
						<div id='name' class='outerDiv'>
							<label for="txtCI">Nº CI:</label> 
                                                        <input type="numeric" maxlength="9"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="txtci" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de CI </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtNombre">Nombre:</label> 
							<input type="text" name="txtnombre" required  /> 
							<div class='message' id='nameDiv'> Ingrese Nombre </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtApellido">Apellido:</label> 
							<input type="text" name="txtapellido" required  /> 
							<div class='message' id='nameDiv'> Ingrese Apellido </div>
						</div>
						<div class='clearfix'></div>
						<div id='username' class='outerDiv'>
							<label for="txtusername">Usuario:</label> 
							<input type="text" name="txtusuario" required  /> 
							<div class='message' id='usernameDiv'> Ingrese Usuario. </div>
						</div>
						<div class='clearfix'></div>
						<div id='password' class='outerDiv'>
							<label for="txtpassword">Password:</label> 
							<input type="password" name="txtpassword" required /> 
							<div class='message' id='websiteDiv'> Ingrese clave Secreta. </div>
						</div>
						<div class='clearfix'></div>
						<div id='email' class='outerDiv'>
							<label for="txtemailx">Email:</label> 
							<input type="email" name="txtemail" /> 
							<div class='message' id='emailDiv'> Ingrese E-mail. </div>
						</div>
						<div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                                <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://192.168.0.99/web/phpsueldos2015/userloget/principal.php'"/>  
                                                </div> 
            
             
                                    </form>
                         
	<div class='clearfix'></div>
                                
            </div>
        
        <div class="centerTable">
             <?php 
                 
                   include './funciones.php';
                        //hace una conexion local
                        conexionlocal();
                        $result = pg_query("SELECT row_number()over (partition by 0 order by usu_cod) as   lineas, usu_cod,usu_ci,usu_nick,usu_nom,usu_ape,usu_pas,email FROM usuario where usu_activo=true order by usu_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3'> \n"; 
                      echo " <caption>Usuarios (Presione Ctrl+F para buscar)</caption>"; 
                       echo "<th>Línea</th><th>Código</th><th>Nombre</th><th>Apellido</th><th>Usuario</th><th>Password</th><th>E-mail</th> \n"; 
                       do { 
                          echo "<tr><td>".$row["lineas"]."</td><td>".$row["usu_cod"]."</td><td>".$row["usu_nom"]."</td><td>".$row["usu_ape"]."</td><td>".$row["usu_nick"]."</td><td>".$row["usu_pas"]."</td><td>".$row["email"]."</td></tr> \n"; 
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
 
<script type="text/javascript">
            
            function Cancelar(){
             
            location.href("http://192.168.0.99/web/phpsueldos2015/principal.php")
    }
</script>
</div>
   <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
    
    
</html>