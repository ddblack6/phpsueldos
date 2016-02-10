<?php 
session_start();
?>
<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */

 include 'userloget/funciones.php';
 conexionlocal();
$usr= $_REQUEST['login'];
$pwd= $_REQUEST['password'];
//$pwd= md5($pwd); esto usaremos despues para comparar carga que se realizara en md5
//session_start();
//print_r($_REQUEST);
//////////////////////////INGRESO DE USUARIO
	$sql= "SELECT * FROM usuario WHERE usu_nick = '$usr' AND usu_pas = MD5('$pwd') and usu_activo=true ";
	//echo "$sql";
	//echo $n.' ---'.$sql; 
	$datosusr = pg_query($sql);
	$n = count($datosusr);
        $row = pg_fetch_array($datosusr);
        
	//echo $n; //numero de elementos que esta en nuestro array"El array viene con el campo podemos hacer referencia de esa manera"
	//print "<br><pre>";
	//print_r($datosusr); 
	//print "</pre>";
	
	if($n == 0)
	{
		echo '<script type="text/javascript">
                         alert("Nombre de usuario o Password no valido..!");
			 window.location="http://192.168.0.99/web/phpsueldos2015/index.php";
                      </script>';
	}
	else
	{
            $_SESSION["nombre_usuario"] = $row['usu_nom'];
            $_SESSION["codigo_usuario"] = $row['usu_cod'];
            header("Location:http://192.168.0.99/web/phpsueldos2015/userloget/principal.php");
	} 
	exit;
?>


