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
$pdf->addText(410,798,10,'Sistema de Registro de Actividades');
$pdf->addText(20,18,10,'Consulta generarada:'.$fechs);
$pdf->addJpegFromFile("../img/intn.jpg",20,798,40,40);
$pdf->restoreState();
$pdf->closeObject();
// termina las lineas
$pdf->addObject($all,'all');
//--------
//desde aqui agregado
$connection_string = 'DRIVER={SQL Server};SERVER=INTN23\SQLEXPRESS;DATABASE=att';
$user = 'sa'; 
$pass = 'caraplana';
$conn=odbc_connect( $connection_string, $user, $pass ); //fin de consulta agregada
//$conexion = mysql_connect("localhost", "root", "");
//mysql_select_db("trabajo", $conexion);
$query='SELECT userid,ssn,name FROM USERINFO';
$result = odbc_exec($conn,$query);
//$result=mysql_query("SELECT act_cod, act_des FROM actividad",$conexion)or die(mysql_error()); //obtener los datos a listar

//while($datatmp = mysql_fetch_assoc($result)) {
while($datatmp = odbc_fetch_row($result)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados   odbc_result($result,2)
	while(odbc_fetch_row($result)) {

	odbc_result($result,1)=>'Codigo',
	odbc_result($result,2)=>'Descripcion',
	odbc_result($result,3)=>'otros'}
	/*'act_cod'=>'Codigo',
	'act_des'=>'Descripcion'*/
);
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	/*'titleFontSize' => 12 //tamaño del titulo
	'textCol' =>array(0.8,0.8,0.8), //color de texto */
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	'xOrientation'=>'center', //alineacion
	'width'=>350 //ancho de tabla
);

$txttitle = "\n\n LISTADO DE ACTIVIDADES "."\n"; //Titulo general
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$pdf->ezTable($data,$titles, '', $options);
$pdf->ezStream();

?>