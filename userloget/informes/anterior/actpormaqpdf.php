<?
include ('class.ezpdf.php'); 

$pdf =& new Cezpdf('a4','portrait'); // Tamaño de hoja y orientacion:'portrait'=vert;'landscape'=hori
$pdf->selectFont('/fonts/courier.afm'); //Fuentes
$pdf->ezSetCmMargins(1,1,1.5,1.5); //Margenes (top,bottom,left,right)
$pdf->ezStartPageNumbers(555,28,10,'','Pagina : {PAGENUM} de {TOTALPAGENUM}',1);

$fechs = date("d-m-Y H:i:s");
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,40,570,40);
$pdf->line(20,795,570,795);
$pdf->addText(62,798,10,'Instituto Nacional de Tecnologia, Normalizacion y Metrologia');
$pdf->addText(410,798,10,'Sistema de Registro de Actividades');
$pdf->addText(20,28,10,'Consulta generarada:'.$fechs);
$pdf->addJpegFromFile("../img/intn.jpg",20,798,40,40);
$pdf->restoreState();
$pdf->closeObject();
// termina las lineas
$pdf->addObject($all,'all');
//--------
$trab=$_GET['trabajo'];
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("trabajo", $conexion);
$result=mysql_query("SELECT trabajo.tra_cod AS codigo,CONCAT(funcionario.fun_nom,' ',funcionario.fun_ape) AS nombre,actividad.act_des AS actividad,
					trabajo_det.trad_obs AS obs,users.nombre AS nom,dependencia.de_item,dependencia.de_fec,equipo.equ_cod,equipo.equ_npc,equipo.equ_npa,trabajo.tra_fec 
				FROM trabajo,trabajo_e,funcionario,actividad,trabajo_det,users,equipo,dependencia 
				WHERE trabajo.fun_cod=funcionario.fun_cod AND trabajo_det.act_cod=actividad.act_cod AND trabajo_det.tra_cod=trabajo.tra_cod 
					AND trabajo.id=users.id AND trabajo.tra_cod=trabajo_e.tra_cod AND dependencia.equ_cod=trabajo_e.equ_cod AND equipo.equ_cod=dependencia.equ_cod 
					AND equipo.equ_cod=trabajo_e.equ_cod AND dependencia.de_est=1 AND trabajo_det.tra_cod=".$trab." 
				ORDER BY trabajo.tra_cod",$conexion)or die(mysql_error()); //obtener los datos a listar

while($datatmp = mysql_fetch_assoc($result)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados
	'codigo'=>'Codigo',
	'nom'=>'Realizado por',
	'actividad'=>'Actividad hecha',
	'tra_fec'=>'Realizado el',
	'obs'=>'Observacion'
);
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	//'xOrientation'=>'center', //alineacion
	//'width'=>350, //ancho de tabla
	'cols'=>array('codigo'=>array('justification'=>'center','width'=>46),
		'nom'=>array('justification'=>'left','width'=>105),
		'actividad'=>array('justification'=>'center','width'=>130),
		'tra_fec'=>array('justification'=>'center','width'=>66),
		'obs'=>array('justification'=>'center','width'=>200))
);
$re=mysql_query("SELECT trabajo.tra_cod AS codigo,CONCAT(funcionario.fun_nom,' ',funcionario.fun_ape) AS nombre,actividad.act_des AS actividad,
					trabajo_det.trad_obs AS obs,users.nombre AS nom,dependencia.de_item,dependencia.de_fec,equipo.equ_cod,equipo.equ_npc,equipo.equ_npa,trabajo.tra_fec 
				FROM trabajo,trabajo_e,funcionario,actividad,trabajo_det,users,equipo,dependencia 
				WHERE trabajo.fun_cod=funcionario.fun_cod AND trabajo_det.act_cod=actividad.act_cod AND trabajo_det.tra_cod=trabajo.tra_cod 
					AND trabajo.id=users.id AND trabajo.tra_cod=trabajo_e.tra_cod AND dependencia.equ_cod=trabajo_e.equ_cod AND equipo.equ_cod=dependencia.equ_cod 
					AND equipo.equ_cod=trabajo_e.equ_cod AND dependencia.de_est=1 AND trabajo_det.tra_cod=".$trab." 
				ORDER BY trabajo.tra_cod",$conexion)or die(mysql_error());
$feyus=mysql_fetch_array($re);

$txttitle = "\n\n LISTADO DE ACTIVIDADES REALIZADAS A LA PC "."\n"; //Titulo general
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$datas = array(array('uno'=>'Maquina: <u>'.$feyus["equ_npc"].'</u>','medio'=>'','dos'=>'Asignado desde: <u>'.$feyus["de_fec"].'</u>'));
$pdf->ezTable($datas,$cols,'',
	array('shadeCol' =>array(10,10,10),'shadeCol2' =>array(10,10,10),'showLines'=> 0,'shaded'=>2,'showHeadings'=>0,'xPos'=>35,
	'width'=>525,'xOrientation'=>'right',
	'cols'=>array('uno'=>array('justification'=>'left','width'=>250),'medio'=>array('justification'=>'center','width'=>50),'dos'=>array('justification'=>'left'))));
$datas2= array(array('uno'=>'Encargado: <u>'.$feyus["nombre"].'</u>','medio'=>'','dos'=>'Nro. Patrimonial: <u>'.$feyus["equ_npa"].'</u>'));
$pdf->ezTable($datas2,$cols,'',
	array('shadeCol' =>array(10,10,10),'shadeCol2' =>array(10,10,10),'showLines'=> 0,'shaded'=>2,'showHeadings'=>0,'xPos'=>35,
	'width'=>525,'xOrientation'=>'right',
	'cols'=>array('uno'=>array('justification'=>'left','width'=>250),'medio'=>array('justification'=>'center','width'=>50),'dos'=>array('justification'=>'left'))));
$pdf->ezText("\n", 12);
$pdf->ezTable($data,$titles, 'Detalles', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezStream();

?>