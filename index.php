
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
<head>
<link rel="stylesheet" href="userloget/twitter-signup.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inicio de Sesión</title>
<link href="Site.css" rel="stylesheet">
<meta name="viewport" content="width=device-width" />
<script type="text/javascript">
function chequeo_forma() {
with (document.formato) {
if ((login.value == "") || (password.value == "")) {
alert('Debe Ingresar Nombre de Usuario y Password');
return false;
}
}
}
</script>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>	
<script>
$(document).ready(function(){
	$("#username").mouseenter(function(evento){
		$("#usernameDiv").css("display", "block");
	});
	$("#username").mouseleave(function(evento){
		$("#usernameDiv").css("display", "none");
	});
	$("#password").mouseenter(function(evento){
		$("#websiteDiv").css("display", "block");
	});
	$("#password").mouseleave(function(evento){
		$("#websiteDiv").css("display", "none");
	});
})
</script>
</head>

<body>
<br><br>

<div id="logo">
<img src="logointn.jpg" alt="" width= "300" height="217"> 
</div>

<div id="content">
<div id="login">
<div id="twitter">
<form name="formato" action="login.php" METHOD=POST onSubmit="return chequeo_forma()">
	 <div id='name' class='outerDiv'>
            <label for="txtdescripcion">Usuario:</label> 
            <div id='username' class='outerDiv'>
            <input name="login" type="text" size="18" required></div>
            <div class='message' id='usernameDiv' style="display: none;"> Ingrese Nombre de Usuario</div>
	</div>
    <div class='clearfix'></div>
	  <div id='name' class='outerDiv'>
        <label for="txtdescripcion">Password:</label> 
		<div id='password' class='outerDiv'>
			<input name="password" type="password" size="18" required>
			<div class='message' id='websiteDiv'  style="display: none;">Ingresar Clave</div>
		</div>
         <div class='clearfix'></div>
		<br><br><input name="Submit" type="submit" class="outerDiv" value="Iniciar Sesión">
               
	</div>
</form>
</div>
</div>

</div>
<div class="footer">

</div>
<br> <br>
</body>
<section class="contact">
    <p>
        Desarrollado por DINF - mriveros@intn.gov.py
    </p>
</section>
</html>
