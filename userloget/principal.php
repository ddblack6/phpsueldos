<?php
if (!isset($_SESSION) ){session_start();}

if(($_SESSION['nombre_usuario'])=='')
   {
    header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/index.php"); 
   }
?>
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
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Principal</title>
    <?php
              echo '<div align="right"><p><strong><H4><i> Bienvenid@ !</i> '.$_SESSION["nombre_usuario"].'</h4></strong></p></div>';
    ?>
	<div class="header">
	  <div class="header_resize">
                <div class="logo">
			<h1><a href="http://192.168.0.99/web/phpsueldos2015/userloget/principal.php"><span>INTN</span>- SUELDOS<br />
			<small>Instituto Nacional de Tecnologia Normalizacion y Metrologia</small></a></h1> 
		</div>
              </br>
	  </div>
	  </div>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.css" >
    <script src="../jquery-1.3.2.min.js" tyzzpe="text/javascript" ></script>
    <script src="js/menu.js" type="text/javascript"></script> 
</head>
<body style="background-image:url('../logointn.jpg'); 
             background-position:center;  
             background-repeat:no-repeat; 
             background-attachment :fixed;">
    

 <div class="mainWrap">
    <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>
    <nav>
    <ul class="menu">
   <li><a href="#"><i class="icon-user"></i>CARGA DATOS</a>
   <ul class="sub-menu">
		<li><a href="#">USUARIOS</a>
                        <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmUsuarioNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmUsuarioModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmUsuarioElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
		<li><a href="#">FUNCIONARIOS</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmFuncionarioNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmFuncionarioModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmFuncionarioElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
                <li><a href="#">CATEGORÍAS</a>
                        <ul><li><a  href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCategoriaNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCategoriaModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCategoriaElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
		<li><a href="#">CARGO</a>
                        <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCargoNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCargoModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCargoElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
		<li><a  href="#">ORGANISMO</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmOrganismoNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmOrganismoModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmOrganismoElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
                <li><a  href="#">LINEA</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmLineaNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmLineaModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmLineaElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
		<li><a href="#">TIPO DESCUENTOS</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmTipoDescuentoNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmTipoDescuentoModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmTipoDescuentoElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
                <li><a href="#">CATEGORIA FUNCIONARIO</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCategoriaDetNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCategoriaDetModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmCategoriaDetElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
                <li><a href="#">ORGANISMO FUNCIONARIO</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmOrganismoDetNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmOrganismoDetModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmOrganismoDetElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
                <li><a href="#">LINEA FUNCIONARIO</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmLineaDetNuevo.php">NUEVO</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmLineaDetModif.php">MODIFICAR</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmLineaDetElim.php">ELIMINAR</a></li>
                        </ul>
                </li>
                </ul>
    </li>
   <li><a href="#"><i class="icon-money"></i>SUELDOS</a>
		<ul class="sub-menu">
                <li><a  href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmGenerarSueldos.php">GENERAR SUELDOS</a>
		<li><a  href="#">REGISTRAR</a>
                    <ul><li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmSalarioF10.php">FUENTE 10</a></li>
                        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmSalarioF30.php">FUENTE 30</a>
                    </ul>
                <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo10.php">SUELDOS FUENTE 10</a></li>
                <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo30.php">SUELDOS FUENTE 30</a></li>
                <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php">SUELDOS GENERAL</a></li>
                </li>
		</ul>
   </li>
  <li><a  href="#"><i class="icon-folder-close-alt"></i>IMPRESIONES</a>
  <ul class="sub-menu">
  <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmGenerarReciboOrgan.php">GENERAR RECIBOS</a></li>    
  <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmReciboFunc.php">IMPRIMIR RECIBO</a></li>
   <li><a href="#">SALARIO / RESUMEN</a>
    <ul>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/InformeSueldoF10.php">SALARIO FUENTE 10</a></li>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/InformeSueldoF30.php">SALARIO FUENTE 30</a></li>
    <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmOrganismos.php">POR ORGANISMOS</a></li>
     <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/InformeSueldoResumen.php">TOTAL GENERAL</a></li>
     <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/InformeSueldoResumenF10.php">TOTAL GENERAL FUENTE 10</a></li>
     <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/InformeSueldoResumenF30.php">TOTAL GENERAL FUENTE 30</a></li>
    </ul>
       <li><a href="#">EXPORTAR A EXCEL</a>
    <ul>
       <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/excel/InformeExcelF10.php">SALARIO FUENTE 10</a></li>
       <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/excel/InformeExcelF30.php">SALARIO FUENTE 30</a></li>
        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/excel/InformeExcelTotal.php">TOTAL GENERAL</a></li>
    </ul>
   </li>
    <li><a href="#">GENERAR TXT</a>
    <ul>
       <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/GenTXT/InformeTxt10.php">FUENTE 10</a></li>
       <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/GenTXT/InformeTxt30.php">FUENTE 30</a></li>
        <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/GenTXT/InformeTxtT.php">GENERAL</a></li>
    </ul>
   </li>
   </ul>
  </li>
  <li><a  href="#"><i class="icon-print"></i>CONSULTAS</a>
  <ul>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmReciboFecha.php">RECIBO POR FECHA</a></li>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmOrganismosFecha.php">ORGANISMOS POR FECHA</a></li>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmResumenFunc.php">FUNCIONARIO FECHA</a></li>
   <li><a href="">RESUMEN FECHA</a>
   <ul>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmResumenTotalFecha.php">RESUMEN TOTAL</a></li>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmResumenF10Fecha.php">RESUMEN F10</a></li>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmResumenF30Fecha.php">RESUMEN F30</a></li>
   </ul>
   </li>
   <li><a href="http://192.168.0.99/web/phpsueldos2015/userloget/excel/FrmExcelFecha.php">EXCEL/FECHA</a>
    </li>
   </ul>
   </li>
  <li><a  href="http://192.168.0.99/web/phpsueldos2015/logout.php"><i class="icon-warning-sign"></i>SALIR</a></li>
  <li><a  href="http://192.168.0.99/web/phpsueldos2015/userloget/Manual de Usuario.pdf"><i class="icon-info-sign"></i>INFO</a></li>
  </ul>
  </nav>       
 </div><!--end mainWrap-->
</body>
</html>