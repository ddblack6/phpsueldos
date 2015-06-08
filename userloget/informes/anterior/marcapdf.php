<?
include ('class.ezpdf.php'); 

$pdf =& new Cezpdf('a4','portrait'); // Tamaño de hoja y orientacion:'portrait'=vert;'landscape'=hori
$pdf->selectFont('/fonts/courier.afm'); //Fuentes
$pdf->ezSetCmMargins(1,1,1.5,1.5); //Margenes (top,bottom,left,right)
$pdf->ezStartPageNumbers(555,17,10,'','Pagina : {PAGENUM} de {TOTALPAGENUM}',1);

$fechs = date("d-m-Y H:i:s");
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,30,570,30);
$pdf->line(20,795,570,795);
$pdf->addText(62,798,10,'Instituto Nacional de Tecnologia, Normalizacion y Metrologia');
$pdf->addText(396,798,10,'Sistema de Relevamiento de Maquinas');
$pdf->addText(20,18,10,'Consulta generarada:'.$fechs);
$pdf->addJpegFromFile("../img/intn.jpg",20,798,40,40);
$pdf->restoreState();
$pdf->closeObject();
// termina las lineas
$pdf->addObject($all,'all');
//--------

$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("trabajo", $conexion);
$result=mysql_query("SELECT mar_cod, mar_des FROM marca",$conexion)or die(mysql_error()); //obtener los datos a listar

while($datatmp = mysql_fetch_assoc($result)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados
	'mar_cod'=>'Codigo',
	'mar_des'=>'Descripcion'
);
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	/*'titleFontSize' => 12 //tamaño del titulo
	'textCol' =>array(0.8,0.8,0.8), //color de texto */
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	'xOrientation'=>'center', //alineacion
	'width'=>350 //ancho de tabla
);

$txttitle = "\n\n LISTADO DE MARCAS "."\n"; //Titulo general
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$pdf->ezTable($data,$titles, '', $options);
$pdf->ezStream();

?>