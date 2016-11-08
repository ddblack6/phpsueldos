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
$result=mysql_query("SELECT trabajo.tra_fec AS fecha,trabajo.tra_cod AS codigo,funcionario.fun_nom AS nombre,actividad.act_des AS actividad,trabajo_det.trad_obs AS obs,users.nombre AS nom ".
			"FROM trabajo, funcionario, actividad, trabajo_det, users ".
			"WHERE trabajo.fun_cod=funcionario.fun_cod AND trabajo_det.act_cod=actividad.act_cod AND trabajo_det.tra_cod=trabajo.tra_cod AND trabajo.id=users.id ".
			"AND trabajo_det.tra_cod=".$trab." ORDER BY trabajo.tra_cod",$conexion)or die(mysql_error()); //obtener los datos a listar

while($datatmp = mysql_fetch_assoc($result)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados
	'codigo'=>'Codigo',
	'nombre'=>'Funcionario',
	'actividad'=>'Actividad',
	'obs'=>'Observacion'
);
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	//'xOrientation'=>'center', //alineacion
	//'width'=>350, //ancho de tabla
	'cols'=>array('codigo'=>array('justification'=>'center','width'=>46),
		'nombre'=>array('justification'=>'left','width'=>90),
		'actividad'=>array('justification'=>'center','width'=>155),
		'obs'=>array('justification'=>'center','width'=>235))
);
$re=mysql_query("SELECT trabajo.tra_fec AS fecha,trabajo.tra_cod AS codigo,users.nombre AS nombre ".
			"FROM trabajo, users WHERE trabajo.id=users.id AND trabajo.tra_cod=".$trab." ORDER BY trabajo.tra_cod",$conexion)or die(mysql_error());
$feyus=mysql_fetch_array($re);

$txttitle = "\n\n LISTADO DE TRABAJOS "."\n"; //Titulo general
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$datas = array(array('uno'=>'Realizado por: <u>'.$feyus["nombre"].'</u>','medio'=>'','dos'=>'Fecha de realizacion: <u>'.$feyus["fecha"].'</u>'));
$pdf->ezTable($datas,$cols,'',
	array('shadeCol' =>array(10,10,10),'shadeCol2' =>array(10,10,10),'showLines'=> 0,'shaded'=>2,'showHeadings'=>0,'xPos'=>35,
	'width'=>525,'xOrientation'=>'right',
	'cols'=>array('uno'=>array('justification'=>'left','width'=>250),'medio'=>array('justification'=>'center','width'=>50),'dos'=>array('justification'=>'left'))));
$pdf->ezText("\n", 12);
$pdf->ezTable($data,$titles, 'Detalles', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezStream();

?>