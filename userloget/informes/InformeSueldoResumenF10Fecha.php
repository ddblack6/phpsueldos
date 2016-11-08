<?php
//Example FPDF script with PostgreSQL
//Ribamar FS - ribafs@dnocs.gov.br

require('fpdf.php');

class PDF extends FPDF{
function Footer()
{
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(343,236,9,236);//largor,ubicacion derecha,inicio,ubicacion izquierda
    // Go to 1.5 cm from bottom
        $this->SetY(-15);
    // Select Arial italic 8
        $this->SetFont('Arial','I',8);
    // Print centered page number
	$this->Cell(0,2,utf8_decode('Página: ').$this->PageNo().' de {nb}',0,0,'R');
	$this->text(10,234,'Consulta Generada: '.date('d-M-Y').' '.date('h:i:s'));
}

function Header()
{
	$this->SetX(20);
    // Select Arial bold 15
    $this->SetFont('Arial','',9);
	$this->Image('img/intn.jpg',20,10,-300,0,'','../../InformeCargos.php');
    // Move to the right
    $this->Cell(80);
    // Framed title
	$this->text(20,32,utf8_decode('Instituto Nacional de Tecnología, Normalización y Metrología'));
	$this->text(315,32,'Sistema - Sueldos');
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(30);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(374,33,20,33);//largor,ubicacion derecha,inicio,ubicacion izquierda
//table header        
    $this->SetXY(20,30);
    $this->SetFont('Arial','B',8);
    $this->SetTitle('RESUMEN GENERAL DE SUELDOS');
    $this->Cell(300,10,'RESUMEN GENERAL DE SUELDOS FUENTE 10',100,100,'C');//Titulo
    $this->SetFillColor(153,192,141);
    $this->SetTextColor(255);
    $this->SetDrawColor(153,192,141);
    $this->SetLineWidth(.3);
    /*$this->Cell(20,10,'SIAPE',1,0,'L',1);
    $this->Cell(50,10,'Nome',1,1,'L',1);*/
    
    $this->Cell(57,10,'ORGANIZACION',1,0,'C',1);
    $this->Cell(33,10,'TOTAL SUELDO BRUTO',1,0,'C',1);
    $this->Cell(33,10,'TOTAL IPS',1,0,'C',1);
    $this->Cell(33,10,'TOTAL AUSENCIAS',1,0,'C',1);
    $this->Cell(33,10,'TOTAL PERMISOS',1,0,'C',1);
    $this->Cell(33,10,'TOTAL JUDICIAL',1,0,'C',1);
    $this->Cell(33,10,'TOTAL ASO',1,0,'C',1);
    $this->Cell(33,10,'TOTAL REPOSO',1,0,'C',1);
    $this->Cell(33,10,'TOTAL DESCUENTOS',1,0,'C',1);
    $this->Cell(33,10,'TOTAL NETO',1,1,'C',1);
//Restore font and colors


}
}
//Recibimos los valores de Fecha para nuestro Informe
 if  (empty($_POST['txtFecha'])){$fecha=0;}else{$fecha=$_POST['txtFecha'];}
 $mes=substr($fecha, 5, 2);
   $anho=substr($fecha, 0, 4);  
$pdf=new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'

$pdf->AddPage('L', 'legal');
//$pdf->AliasNbPages();
$pdf->SetFont('Arial','',6);

//Connection and query
$conectate=pg_connect("host=192.168.0.18 port=5432 dbname=salario2016 user=postgres password=postgres_server"
                    . "")or die ('Error al conectar a la base de datos');
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);

/*
 * 
 * 
 * Aqui haremos las consultas para los totales
 * 
 * 
 */
$pdf->SetFont('Arial','B',8);
$consulta2=pg_exec($conectate,"SELECT 
    max(org.org_des) as organizacion,
    sum(cat.cat_nom)as sueldobruto,
    sum(SAL.sal_ips)as ips,
    sum(SAL.sal_aus)as ausencia,
    sum(SAL.sal_pyt)as permiso,
    sum(SAL.sal_jud)as judicial,
    sum(SAL.sal_aso)as aso,
    sum(SAL.sal_rep)as reposo,
    sum(DES.ode_mon)as descuentos,
    sum(SAL.sal_neto) as totalneto
    from Salario SAL
    LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
    INNER JOIN funcionario FUN 
    on SAl.fun_cod=FUN.fun_cod 
    LEFT OUTER JOIN tipo_descuento TIPDES
    on TIPDES.tde_cod=DES.tde_cod
    INNER JOIN categoria_detalle catdet
    on sal.fun_cod= catdet.fun_cod
    INNER JOIN categoria cat
    on cat.cat_cod=catdet.cat_cod
    INNER JOIN organismo_detalle orgdet
    on sal.fun_cod= orgdet.fun_cod
    INNER JOIN organismo org
    on org.org_cod=orgdet.org_cod
    where SAL.fun_cod=FUN.fun_cod
    and EXTRACT(MONTH FROM sal_fecha)=$mes
    and EXTRACT(YEAR FROM sal_fecha)=  $anho
    and FUN.fun_fuente='10'
    group by org.org_des
    order by organizacion");

$numregs2=pg_numrows($consulta2);

//Build table
$fill=false;
$i=0;

$BRUtAcum=0;
$IPSAcum=0;
$AUSAcum=0;
$PERAcum=0;
$JUDAcum=0;
$ASOAcum=0;
$REPAcum=0;
$ODEAcum=0;
$NETAcum=0;

while($i<$numregs2)
{   
	$pdf->SetX(20);
    $Organizacion=pg_result($consulta2,$i,'organizacion');
    
    $SueldoBrutoT=pg_result($consulta2,$i,'sueldobruto');
    $BRUtAcum=$BRUtAcum+$SueldoBrutoT;
    
    $IPST=pg_result($consulta2,$i,'ips');
    $IPSAcum=$IPSAcum+$IPST;
    
    $AusenciaT=pg_result($consulta2,$i,'ausencia');
    $AUSAcum=$AUSAcum+$AusenciaT;
    
    $PermisoT=pg_result($consulta2,$i,'permiso');
    $PERAcum=$PERAcum+$PermisoT;
    
    $JudicialT=pg_result($consulta2,$i,'judicial');
    $JUDAcum=$JUDAcum+$JudicialT;
    
    $ASOT=pg_result($consulta2,$i,'aso');
    $ASOAcum=$ASOAcum+$ASOT;
    
    $ReposoT=pg_result($consulta2,$i,'reposo');
    $REPAcum=$REPAcum+$ReposoT;
    
    $OdescuentosT=pg_result($consulta2,$i,'descuentos');
    $ODEAcum=$ODEAcum+$OdescuentosT;
    
    $NetoT=pg_result($consulta2,$i,'totalneto');
    $NETAcum=$NETAcum+$NetoT;
    
   $pdf->Cell(57,10,$Organizacion,1,0,'L',$fill); 
    $pdf->Cell(33,10,number_format($SueldoBrutoT, 0, '', '.'),1,0,'C',$fill); 
    $pdf->Cell(33,10,number_format($IPST, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($AusenciaT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($PermisoT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($JudicialT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($ASOT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($ReposoT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($IPST+$AusenciaT+$PermisoT+$JudicialT+$ASOT+$ReposoT+$OdescuentosT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($NetoT, 0, '', '.'),1,1,'C',$fill);
    $fill=!$fill;
    $i++;
}
	$pdf->SetX(20);
	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(57,10,'TOTAL GENERAL',1,0,'L',$fill); 
    $pdf->Cell(33,10,number_format($BRUtAcum, 0, '', '.'),1,0,'C',$fill); 
    $pdf->Cell(33,10,number_format($IPSAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($AUSAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($PERAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($JUDAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($ASOAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($REPAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($IPSAcum+$AUSAcum+$PERAcum+$JUDAcum+$ASOAcum+$REPAcum+$ODEAcum, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(33,10,number_format($NETAcum, 0, '', '.'),1,1,'C',$fill);
    

//Add a rectangle, a line, a logo and some text
/*
$pdf->Rect(5,5,170,80);
$pdf->Line(5,90,90,90);
//$pdf->Image('mouse.jpg',185,5,10,0,'JPG','http://www.dnocs.gov.br');
$pdf->SetFillColor(224,235);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,95);
$pdf->Cell(170,5,'PDF gerado via PHP acessando banco de dados - Por Ribamar FS',1,1,'L',1,'mailto:ribafs@dnocs.gov.br');
*/
$pdf->Output('Resumen General Sueldos.pdf','I');
$pdf->Close();
?>