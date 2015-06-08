<?
include ('class.ezpdf.php'); 

$pdf =& new Cezpdf('a4','landscape'); // Tamaño de hoja y orientacion:'portrait'=vert;'landscape'=hori
$pdf->selectFont('/fonts/courier.afm'); //Fuentes
$pdf->ezSetCmMargins(1,1,1.5,1.5); //Margenes (top,bottom,left,right)
$pdf->ezStartPageNumbers(810,29,10,'','Pagina : {PAGENUM} de {TOTALPAGENUM}',1);

$fechs = date("d-m-Y H:i:s");
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
/*$pdf->line(20,55,570,55);
$pdf->line(20,790,570,790);
$pdf->addText(55,795,10,'Instituto Nacional de Tecnologia, Normalizacion y Metrologia');
$pdf->addText(394,795,10,'Sistema de Relevamiento de Maquinas');
$pdf->addText(20,45,10,'Generado el: '.$fechs);
$pdf->addJpegFromFile("../img/INTN.jpg",20,795,30,30);*/
$pdf->line(20,40,820,40);//inicio,ubicacion izquierda,fin,ubicacion derecha
$pdf->line(20,550,820,550);//inicio,ubicacion izquierda,fin,ubicacion derecha
$pdf->addText(55,553,10,'Instituto Nacional de Tecnologia, Normalizacion y Metrologia');
$pdf->addText(645,553,10,'Sistema de Relevamiento de Maquinas');
$pdf->addText(20,29,10,'Generado el: '.$fechs);
$pdf->addJpegFromFile("../img/INTN.jpg",20,553,30,30);

$pdf->restoreState();
$pdf->closeObject();
// termina las lineas
$pdf->addObject($all,'all');
//--------
$conexion = mysql_connect("192.168.0.99", "root", "");
mysql_select_db("trabajo", $conexion);

$resultado=mysql_query("select di.dei_item, d.dep_des, di.dei_fec, m.mar_des, i.imp_mod, i.imp_nse, i.imp_npa, i.imp_estado from dependencia_imp di,departamento d,marca m,impresora i where d.dep_cod=di.dep_cod and m.mar_cod=i.mar_cod and i.imp_cod=di.imp_cod",$conexion)or die(mysql_error());

$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	/*'titleFontSize' => 12 //tamaño del titulo
	'textCol' =>array(0.8,0.8,0.8), //color de texto */
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	'xOrientation'=>'center', //alineacion
	//'width'=>350 //ancho de tabla
);

//$datas = array(array('uno'=>'Encargado del relevamiento: '.$dato["nombre"].'','medio'=>'','dos'=>'Fecha de realizacion: '.$dato["imp_fecha"].''));
$pdf->ezText("\n");
//$pdf->ezText("\n\n");
/*
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
*/
//aqui va
while($datatmp = mysql_fetch_assoc($resultado)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados
	'dei_item'=>'Codigo',
	'dep_des'=>'Departamento',
	'dei_fec'=>'Cargado el',
	'mar_des'=>'Marca',
	'imp_mod'=>'Modelo',
	'imp_nse'=>'Num. Serie',
	'imp_npa'=>'Num. Patrimonial',
	'imp_estado'=>'Estado'
);

$txttitle = "\n Impresoras por Departamento. "."\n"; //Titulo general
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$pdf->ezTable($data,$titles, '', $options);
$pdf->ezStream();

?>