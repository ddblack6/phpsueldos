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
$conexion = mysql_connect("192.168.0.99", "root", "");
mysql_select_db("trabajo", $conexion);

$resultado=mysql_query("SELECT users.nombre, impresora.imp_cod, funcionario.fun_nom, funcionario.fun_ape, departamento.dep_des, marca.mar_des, impresora.imp_fecha, impresora.imp_npa, impresora.imp_nse, impresora.imp_mod, impresora.imp_tti, impresora.imp_ti1, impresora.imp_ti2, impresora.imp_ti3, impresora.imp_ti4, impresora.imp_estado, dependencia_imp.dei_fec  
FROM impresora,funcionario,departamento,marca,users, dependencia_imp WHERE funcionario.dep_cod=departamento.dep_cod ANd impresora.mar_cod=marca.mar_cod AND funcionario.fun_cod=dependencia_imp.fun_cod AND impresora.imp_cod=dependencia_imp.imp_cod AND users.id=impresora.id AND dependencia_imp.dei_est=1",$conexion)or die(mysql_error()); //obtener los datos a listar  (SELECT MAX(dependencia_imp.dei_fec) FROM impresora, departamento, funcionario, dependencia_imp WHERE impresora.imp_cod = dependencia_imp.imp_cod AND dependencia_imp.fun_cod=funcionario.fun_cod AND departamento.dep_cod=funcionario.dep_cod)
$dato=mysql_fetch_array($resultado);

/*while($datatmp = mysql_fetch_assoc($result)) {
	$data[] = $datatmp;
}*/
/*$titles = array( //Los campos y sus respectivos encabezados
	'acc_des'=>'Accesorio',
	'mar_des'=>'Marca',
	'acc_nse'=>'Numero de Serie',
	'acc_mod'=>'Modelo',
	'acc_npa'=>'Numero Patrimonial',
	'acc_tco'=>'Tipo de Conexion',
	'acc_est'=>'Estado',
	'eqd_fec'=>'Fecha'
);*/
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	/*'titleFontSize' => 12 //tamaño del titulo
	'textCol' =>array(0.8,0.8,0.8), //color de texto */
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	'xOrientation'=>'center', //alineacion
	//'width'=>350 //ancho de tabla
);

$txttitle = "\n Detalle de la Impresora. "."\n"; //Titulo general
$datas = array(array('uno'=>'Encargado del relevamiento: '.$dato["nombre"].'','medio'=>'','dos'=>'Fecha de realizacion: '.$dato["imp_fecha"].''));
$pdf->ezText("\n\n");
$pdf->ezTable($datas,$cols,'',
array('shadeCol' =>array(0.8,0.8,0.8),'shadeCol2' =>array(0.8,0.8,0.8),'showLines'=> 0,'shaded'=>2,'showHeadings'=>0,'xPos'=>30,
'width'=>525,'xOrientation'=>'right',
'cols'=>array('uno'=>array('justification'=>'left','width'=>260),'medio'=>array('justification'=>'center','width'=>30),'dos'=>array('justification'=>'right'))));
$pdf->ezText($txttitle, 15,array('justification'=>'center'));
$pdf->ezText("\n Encargado de la impresora: ".$dato["fun_nom"]." ".$dato["fun_ape"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Departamento: ".$dato["dep_des"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Fecha de Asignacion: ".$dato["dei_fec"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Marca de la impresora : ".$dato["mar_des"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Numero Patrimonial: ".$dato["imp_npa"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Numero de Serie: ".$dato["imp_nse"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Modelo: ".$dato["imp_mod"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Tipo de Tinta: ".$dato["imp_tti"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Tinta 1: ".$dato["imp_ti1"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Tinta 2: ".$dato["imp_ti2"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Tinta 3: ".$dato["imp_ti3"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Tinta 4: ".$dato["imp_ti4"]."", 12,array('justification'=>'left'));
$pdf->ezText(" Estado de la impresora : ".$dato["imp_estado"]."", 12,array('justification'=>'left'));

$pdf->ezTable($data,$titles, '', $options);
$pdf->ezStream();

?>