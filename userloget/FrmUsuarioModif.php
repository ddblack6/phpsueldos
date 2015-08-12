
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
             
            location.href("http://localhost/app/phpsueldos/principal.php")
           
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
$result = pg_query("SELECT usu_cod,usu_ci,usu_nick,usu_nom,usu_ape,MD5(usu_pas)as usu_pas,email FROM usuario where usu_cod= ".$codigo); 
$row = pg_fetch_array($result);

?>
    </head>
    <body>
        <?php include("principal.php");?>
        <div id="twitter">
        <div class='clearfix'></div>

                    <div id="twitter">
                        <form autocomplete="off" action="clases/ClsUsuario.php?nuevo=2" method="post" onClik="submit" title="Datos de Usuarios"> 
                                                        <div id='name' class='outerDiv'>
							<input type="hidden" name="txtcodigo" value="<?php echo $row['usu_cod'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de CI </div>
                                                            </div>
						<div id='name' class='outerDiv'>
                                                    
							<label for="txtCI">Nº CI:</label> 
							<input type="text" name="txtci" value="<?php echo $row['usu_ci'];?>" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de CI </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtNombre">Nombre:</label> 
							<input type="text" name="txtnombre" value="<?php echo $row['usu_nom'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese Nombre </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div id='name' class='outerDiv'>
							<label for="txtApellido">Apellido:</label> 
							<input type="text" name="txtapellido" value="<?php echo $row['usu_ape'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese Apellido </div>
						</div>
						<div class='clearfix'></div>
						<div id='username' class='outerDiv'>
							<label for="txtusername">Usuario:</label> 
							<input type="text" name="txtusuario" value="<?php echo $row['usu_nick'];?>" required  /> 
							<div class='message' id='usernameDiv'> Ingrese Usuario. </div>
						</div>
						<div class='clearfix'></div>
						<div id='password' class='outerDiv'>
							<label for="txtpassword">Password:</label> 
                                                        <input type="password" name="txtpassword" value="<?php echo $row['usu_pas'];?>" required /> 
							<div class='message' id='websiteDiv'> Ingrese clave Secreta. </div>
						</div>
						<div class='clearfix'></div>
						<div id='email' class='outerDiv'>
							<label for="txtemailx">Email:</label> 
							<input type="email" name="txtemail" value="<?php echo $row['email'];?>" /> 
							<div class='message' id='emailDiv'> Ingrese E-mail. </div>
						</div>
						<div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                                <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldos/userloget/principal.php'"/>  
                                                </div>
                                                <div class='clearfix'></div>
                                                
                                                
                            </form>       
                           
                            </div>
        <div class="centerTable" >
             <?php 
                  
                  // include './funciones.php';
                   //hace una conexion local
                     // conexionlocal();
                      $result = pg_query("SELECT row_number()over (partition by 0 order by usu_cod) as   lineas, usu_cod,usu_ci,usu_nick,usu_nom,usu_ape,usu_pas,email FROM usuario where usu_activo=true order by usu_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                       echo " <caption>Modificar Usuarios (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código</th><th>C.I. Nº</th><th>Nombre</th><th>Apellido</th><th>Usuario</th><th>Password</th><th>E-mail</th><th>Modificar</th> \n"; 
                       do { 
                       echo "<tr><td>".$row["lineas"]."</td><td>".$row["usu_cod"]."</td><td>".$row["usu_ci"]."</td><td>".$row["usu_nom"]."</td><td>".$row["usu_ape"]."</td><td>".$row["usu_nick"]."</td><td>".$row["usu_pas"]."</td><td>".$row["email"]."</td><td><span class='editar' value='".$row["usu_cod"]."' , OnClick='Modificar(".$row["usu_cod"].");'>Editar</span></td></tr> \n"; 
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
  </div>
<a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
    
    
</html>
