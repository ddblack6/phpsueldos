<?
include ('class.ezpdf.php'); 

$pdf =& new Cezpdf('a4','portrait'); // Tamaño de hoja y orientacion:'portrait'=vert;'landscape'=hori
$pdf->selectFont('/fonts/courier.afm'); //Fuentes
$pdf->ezSetCmMargins(1,1,1.5,1.5); //Margenes (top,bottom,left,right)
$pdf->ezStartPageNumbers(555,45,10,'','Pagina : {PAGENUM} de {TOTALPAGENUM}',1);
$fechs = date("d-m-Y H:i:s");
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,55,570,55);
$pdf->line(20,790,570,790);
$pdf->addText(55,795,10,'Instituto Nacional de Tecnologia, Normalizacion y Metrologia');
$pdf->addText(394,795,10,'Sistema de Relevamiento de Maquinas');
$pdf->addText(20,45,10,'Generado el: '.$fechs);
$pdf->addJpegFromFile("../img/INTN.jpg",20,795,30,30);

$pdf->restoreState();
$pdf->closeObject();
// termina las lineas
$pdf->addObject($all,'all');
//--------
$codi=$_POST["equipo"];
//$codi=1;
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("trabajo", $conexion);

$resultado=mysql_query("SELECT dependencia.de_fec,users.nombre,equipo.equ_cod,funcionario.fun_nom,funcionario.fun_ape,departamento.dep_des,marca.mar_des,equipo.equ_fec,equipo.equ_npa,equipo.equ_mem,equipo.equ_hdd,equipo.equ_tco,equipo.equ_con,equipo.equ_ip,equipo.equ_so,equipo.equ_sos,equipo.equ_mac,equipo.equ_npc,equipo.equ_gru,equipo.equ_ddd,equipo.equ_disk,equipo.equ_off,equipo.equ_obs 
FROM equipo,funcionario,departamento,marca,users,dependencia WHERE funcionario.dep_cod=departamento.dep_cod AND equipo.mar_cod=marca.mar_cod AND funcionario.fun_cod=dependencia.fun_cod AND equipo.equ_cod=dependencia.equ_cod AND users.id=equipo.id AND equipo.equ_cod=".$codi." AND dependencia.de_est=1",$conexion)or die(mysql_error()); //obtener los datos a listar   (SELECT MAX(dependencia.de_fec) FROM equipo,departamento,funcionario,dependencia WHERE equipo.equ_cod=dependencia.equ_cod AND departamento.dep_cod=funcionario.dep_cod AND funcionario.fun_cod=dependencia.fun_cod)
$dato=mysql_fetch_array($resultado);

$result=mysql_query("SELECT  accesorio.acc_des, marca.mar_des, accesorio.acc_des, accesorio.acc_nse, accesorio.acc_mod, accesorio.acc_npa, accesorio.acc_tco, accesorio.acc_est, equipo_det.eqd_fec FROM accesorio, marca, equipo_det
WHERE accesorio.mar_cod=marca.mar_cod AND equipo_det.acc_cod=accesorio.acc_cod AND equipo_det.equ_cod=".$codi." ",$conexion)or die(mysql_error()); //obtener los datos a listar

while($datatmp = mysql_fetch_assoc($result)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados
	'acc_des'=>'Accesorio',
	'mar_des'=>'Marca',
	'acc_nse'=>'Numero de Serie',
	'acc_mod'=>'Modelo',
	'acc_npa'=>'Numero Patrimonial',
	'acc_tco'=>'Tipo de Conexion',
	'acc_est'=>'Estado',
	'eqd_fec'=>'Fecha'
);
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	/*'titleFontSize' => 12 //tamaño del titulo
	'textCol' =>array(0.8,0.8,0.8), //color de texto */
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	'xOrientation'=>'center', //alineacion
	//'width'=>350 //ancho de tabla
);

$txttitle = "\n LISTADO DE ACCESORIOS DE LA MAQUINA "."\n"; //Titulo general
$datas = array(array('uno'=>'Encargado del relevamiento: '.$dato["nombre"].'','medio'=>'','dos'=>'Fecha de realizacion: '.$dato["equ_fec"].''));
$pdf->ezText("\n\n");
$pdf->ezTable($datas,$cols,'',
array('shadeCol' =>array(0.8,0.8,0.8),'shadeCol2' =>array(0.8,0.8,0.8),'showLines'=> 0,'shaded'=>2,'showHeadings'=>0,'xPos'=>30,
'width'=>525,'xOrientation'=>'right',
'cols'=>array('uno'=>array('justification'=>'left','width'=>260),'medio'=>array('justification'=>'center','width'=>30),'dos'=>array('justification'=>'right'))));

$pdf->ezText("\n Encargado del equipo: ".$dato["fun_nom"]." ".$dato["fun_ape"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Departamento: ".$dato["dep_des"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Fecha de asignacion: ".$dato["de_fec"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Nombre del equipo : ".$dato["equ_npc"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Marca del equipo : ".$dato["mar_des"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Numero Patrimonial: ".$dato["equ_npa"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Memoria RAM: ".$dato["equ_mem"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Disco Duro: ".$dato["equ_hdd"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Tipo de Conexion: ".$dato["equ_tco"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Conexion: ".$dato["equ_con"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Direccion I.P.: ".$dato["equ_ip"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Sistema Operativo: ".$dato["equ_so"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Serial: ".$dato["equ_sos"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Mac: ".$dato["equ_mac"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Grupo de Trabajo : ".$dato["equ_gru"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Dsipositivo de Disoc : ".$dato["equ_ddd"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Dispositivo de Diskette : ".$dato["equ_disk"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Version de Office : ".$dato["equ_off"]."", 12,array('justification'=>'left'));
$pdf->ezText("\n Observacion : ".$dato["equ_obs"]."", 12,array('justification'=>'left'));
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$pdf->ezTable($data,$titles, '', $options);
ob_end_clean(); 
$pdf->ezStream();

?>