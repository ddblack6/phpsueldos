<?php
//Example FPDF script with PostgreSQL
//Ribamar FS - ribafs@dnocs.gov.br

require('fpdf.php');
include './../../MonedaTexto.php';
class PDF extends FPDF{
function Footer()
{
        $this->text(45,122,'------------------------');
        $this->text(48,126,'Jefe Tesoreria');
        $this->text(150,122,'------------------------');
	$this->text(155,126,'Interesado');
        $this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	//$this->Line(343,203,9,203);//largor,ubicacion derecha,inicio,ubicacion izquierda
}

function Header()
{
   // Select Arial bold 15
    $this->SetFont('Arial','',12);
	$this->Image('img/intn.jpg',6,1,-300,0,'','../../InformeCargos.php');
    // Move to the right
    $this->Cell(80);
    // Framed title
	$this->text(60,10,utf8_decode('Instituto Nacional de Tecnología, Normalización y Metrología'));
	$this->text(100,15,'Asuncion - Paraguay');
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(25);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	//$this->Line(343,20,0,20);//largor,ubicacion derecha,inicio,ubicacion izquierda
}
}
/*Recibimos el numero de cedula
 * realizamos la connexion a la base de datos
 * realizamos la consulta
 */
    if  (empty($_POST['txtCIConfirm'])){$nroci=0;}else{$nroci=$_POST['txtCIConfirm'];}
    if  (empty($_POST['txtFecha'])){$fecha=0;}else{$fecha=$_POST['txtFecha'];}
   
    $mes=substr($fecha, 5, 2);
	$anho=substr($fecha,0, 4);
  
    
if($nroci==0)
	{
			echo '<script type="text/javascript">
			alert("No hay datos para mostrar");
			 window.location="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmReciboFecha.php";
			 </script>';
			}
//Connection and query
$conectate=pg_connect("host=192.168.0.99 port=5432 dbname=salario user=postgres password=postgres"
                    . "")or die ('Error al conectar a la base de datos');
/*
 * aqui realizamos la consulta y cargamos los datos en valores..
 */
$consulta=pg_exec($conectate,"SELECT row_number()over (partition by 0 order by max(SAL.sal_cod)) as lineas,
                    max(Sal.usu_cod) as usu_cod 
                    ,max(Sal.sal_cod)as sal_cod,
                    max(Sal.fun_cod) as fun_cod,
                    max(CONCAT(FUN.fun_nom,' ',FUN.fun_ape)) as nombres,max(FUN.fun_ficha)as ficha,
                    max(FUN.fun_ci) as fun_ci,
                    max(to_char(SAL.sal_fecha,'dd/mm/yyyy')) as sal_fecha,
                    max(SAL.sal_ips) as sal_ips,
                    max(CAT.cat_nom) as cat_nom,
                    max(SAL.sal_aus) as sal_aus,
                    max(SAL.sal_pyt) as sal_pyt,
                    max(SAL.sal_jud) as sal_jud,
                    max(SAL.sal_aso) as sal_aso,
                    max(SAL.sal_rep)as sal_rep,
                    (max(SAL.sal_ips)+ max(SAL.sal_aus)+max(SAL.sal_pyt)+max(SAL.sal_jud)+max(SAL.sal_aso)+max(SAL.sal_rep)) as total_descuentos,
                    sum(DES.ode_mon) as ode_mon,
                    'Otros Descuentos' as tde_des,
                    max(SAL.sal_neto) as sal_neto 
                    from Salario SAL
                    LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
                    LEFT OUTER JOIN tipo_descuento TIPDES on TIPDES.tde_cod=DES.tde_cod
                    INNER JOIN funcionario FUN on SAl.fun_cod=FUN.fun_cod 
                    INNER JOIN categoria_detalle CATDES on FUN.fun_cod=CATDES.fun_cod
                    INNER JOIN categoria CAT on CAT.cat_cod=CATDES.cat_cod
                    where SAL.fun_cod=FUN.fun_cod and FUN.fun_ci='$nroci' 
                    and EXTRACT(MONTH FROM sal_fecha)=$mes
                    and EXTRACT(YEAR FROM sal_fecha)=$anho group by FUN.fun_cod order by nombres ");
//***********************************Consulta sumatoria de descuentos*****************************

 


    $numregs=pg_numrows($consulta);
    if($numregs==0)
	{
			echo '<script type="text/javascript">
			alert("No hay datos para mostrar");
			 window.location="http://192.168.0.99/web/phpsueldos2015/userloget/informes/FrmReciboFecha.php";
			 </script>';
        }
        
    //Build table
    $fill=false;
    $i=0;
    $item=pg_result($consulta,$i,'lineas');
    $funcionario=pg_result($consulta,$i,'nombres');
    $fecha=pg_result($consulta,$i,'sal_fecha');
    $ficha=pg_result($consulta,$i,'ficha');
    $CI=pg_result($consulta,$i,'fun_ci');
    $sueldoBruto=pg_result($consulta,$i,'cat_nom');
    $IPS=pg_result($consulta,$i,'sal_ips');
    $Ausencia=pg_result($consulta,$i,'sal_aus');
    $Permiso=pg_result($consulta,$i,'sal_pyt');
    $Judicial=pg_result($consulta,$i,'sal_jud');
    $ASO=pg_result($consulta,$i,'sal_aso');
    $Reposo=pg_result($consulta,$i,'sal_rep');
    $TotalDes=pg_result($consulta,$i,'total_descuentos');
    $Odescuentos=pg_result($consulta,$i,'ode_mon');
    $Neto=pg_result($consulta,$i,'sal_neto');
//********************************************************************************

        
$pdf=new PDF();
$pdf->AddPage('P','recibo' );
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,0,'Fecha:',0,0,'L',false);//Fecha
$pdf->text(23,36,$fecha);
$pdf->Ln(4);
$pdf->Cell(0,0,'Nombre Funcionario:',0,0,'L',false);//Nombre de Funcionario
$pdf->text(45,40,$funcionario);
$pdf->text(147,40,'Ficha:');
$pdf->text(158,40,$ficha);
$pdf->Ln(4);
$pdf->Cell(0,0,'C.I.:',0,0,'L',false);//numero de cedula de identidad
$pdf->text(19,44,$CI);
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('Descripción:'),0,0,'L',false);//descripcion..este campo no se usa
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('Liquidacion y Pagos por: SUELDOS'),0,0,'L',false);//llenamos por defecto SUELDOS
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('Correspondiente al mes de:'),0,0,'L',false);//mes y anho del salario
$mes=substr($fecha, 3, 2);
$pdf->text(57,56,utf8_decode(genMonth_Text($mes)));
$pdf->Ln(10);
$pdf->Cell(0,0,utf8_decode('POR LA SUMA DE:'),0,0,'L',false); //monto del pago
$pdf->text(152,66,'Gs:');
$pdf->text(158,66,number_format($sueldoBruto),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('MENOS:'),0,0,'L',false);//los descuentos van por debajo
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- I.P.S.:'),0,0,'L',false);//descuento IPS 9%
$pdf->text(80,74,"Gs: ");
$pdf->text(90,74,number_format($IPS),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- Ausencias:'),0,0,'L',false);// descuento de ausencias
$pdf->text(80,78,"Gs: ");
$pdf->text(90,78,number_format($Ausencia),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- Permisos, Llegadas Tardias:'),0,0,'L',false);//descuento de permisos y llegadas tardias
$pdf->text(80,82,"Gs: ");
$pdf->text(90,82,number_format($Permiso),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- ASO:'),0,0,'L',false);//descuento de ASO
$pdf->text(80,86,"Gs: ");
$pdf->text(90,86,number_format($ASO),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- Reposo:'),0,0,'L',false);//descuento por reposo
$pdf->text(80,90,"Gs: ");
$pdf->text(90,90,number_format($Reposo),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- Judiciales:'),0,0,'L',false);//descuento por reposo
$pdf->text(80,94,"Gs: ");
$pdf->text(90,94,number_format($Judicial),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- Otros Descuentos:'),0,0,'L',false);//descuentos Judiciales esto es otros descuentos
$pdf->text(80,98,"Gs: ");
$pdf->text(90,98,number_format($Odescuentos),0, '', '.');
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('- Total Descuentos:'),0,0,'L',false);//aqui si fijamos el descuento de judiciales..
$pdf->text(152,102,'Gs:');
$pdf->text(158,102,number_format($IPS+$Ausencia+$Permiso+$ASO+$Reposo+$Judicial+$Odescuentos),0, '', '.');
$pdf->Line(158,103,177,103);
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('Saldo a Cobrar:'),0,0,'L',false);//salario a cobrar
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('Son:'),0,0,'L',false);
$pdf->text(20,110,convertirMonto((int)($Neto)));
$pdf->text(152,110,'Gs:');
$pdf->text(158,110,number_format($Neto),0, '', '.');
$pdf->Line(158,111,177,111);
$pdf->Line(158,112,177,112);
 
//Table header
/*$pdf->Cell(20,10,'SIAPE',1,0,'L',1);
$pdf->Cell(50,10,'Nome',1,1,'L',1);*/
ob_end_clean();
$pdf->Output();
$pdf->Close();
function genMonth_Text($m) { 
 switch ($m) { 
  case '01': $month_text = "Enero"; break; 
  case '02': $month_text = "Febrero"; break; 
  case '03': $month_text = "Marzo"; break; 
  case '04': $month_text = "Abril"; break; 
  case '05': $month_text = "Mayo"; break; 
  case '06': $month_text = "Junio"; break; 
  case '07': $month_text = "Julio"; break; 
  case '08': $month_text = "Agosto"; break; 
  case '09': $month_text = "Septiembre"; break; 
  case '10': $month_text = "Octubre"; break; 
  case '11': $month_text = "Noviembre"; break; 
  case '12': $month_text = "Diciembre"; break; 
 } 
 return ($month_text); 
} 
?>