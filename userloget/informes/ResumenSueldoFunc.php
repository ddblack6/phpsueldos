<?php
//Example FPDF script with PostgreSQL
//Ribamar FS - ribafs@dnocs.gov.br

require('fpdf.php');

class PDF extends FPDF{
function Footer()
{
        
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(343,203,9,203);//largor,ubicacion derecha,inicio,ubicacion izquierda
    // Go to 1.5 cm from bottom
        $this->SetY(-15);
    // Select Arial italic 8
        $this->SetFont('Arial','I',8);
    // Print centered page number 
	$this->Cell(0,10,utf8_decode('Página: ').$this->PageNo().' de {nb}',0,0,'R');
	$this->text(10,207,'Consulta Generada: '.date('d-M-Y').' '.date('h:i:s'));
}

function Header()
{
   // Select Arial bold 15
    $this->SetFont('Arial','',9);
	$this->Image('img/intn.jpg',10,4,-300,0,'','../../InformeCargos.php');
    // Move to the right
    $this->Cell(80);
    // Framed title
	$this->text(25,22,utf8_decode('Instituto Nacional de Tecnología, Normalización y Metrología'));
	$this->text(296,22,'Sistema - Sueldos');
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(20);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(343,23,9,23);//largor,ubicacion derecha,inicio,ubicacion izquierda
}
}

$pdf=new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'

$pdf->AddPage('L', 'Legal');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',16);
$pdf->SetTitle('LISTADO DE SUELDOS');
$pdf->Cell(300,10,'Listado Sueldos por Funcionario',100,100,'C');//Titulo

//Set font and colors

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(153,192,141);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(153,192,141);
$pdf->SetLineWidth(.3);


//Table header
/*$pdf->Cell(20,10,'SIAPE',1,0,'L',1);
$pdf->Cell(50,10,'Nome',1,1,'L',1);*/

$pdf->Cell(15,10,'Item',1,0,'C',1);
$pdf->Cell(55,10,'Funcionario',1,0,'C',1);
$pdf->Cell(20,10,'Fecha',1,0,'C',1);
$pdf->Cell(25,10,'Sueldo Bruto',1,0,'C',1);
$pdf->Cell(25,10,'IPS',1,0,'C',1);
$pdf->Cell(25,10,'Ausencia',1,0,'C',1);
$pdf->Cell(25,10,'Permisos',1,0,'C',1);
$pdf->Cell(25,10,'Judicial',1,0,'C',1);
$pdf->Cell(25,10,'ASO',1,0,'C',1);
$pdf->Cell(25,10,'Reposo',1,0,'C',1);
$pdf->Cell(30,10,'Otros Descuentos',1,0,'C',1);
$pdf->Cell(30,10,'Neto a Cobrar',1,1,'C',1);
//Restore font and colors
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
//traemos los valores del formulario
 if  (empty($_POST['txtCIConfirm'])){$nroci=0;}else{$nroci=$_POST['txtCIConfirm'];}
 if  (empty($_POST['txtfechadesde'])){$desdefecha=0;}else{$desdefecha=$_POST['txtfechadesde'];}
 if  (empty($_POST['txtfechahasta'])){$hastafecha=0;}else{$hastafecha=$_POST['txtfechahasta'];}
//Connection and query

$pregunta='dbname=dbsalario port=5432 user=postgres password=postgres';
$conectate=pg_connect("host=192.168.0.99 port=5432 dbname=salario user=postgres password=postgres"
                    . "")or die ('Error al conectar a la base de datos');


$consulta=pg_exec($conectate,"SELECT row_number()over (partition by 0 order by max(SAL.sal_cod)) as lineas,
                    max(Sal.usu_cod) as usu_cod,max(Sal.sal_cod)as sal_cod,max(Sal.fun_cod) as fun_cod,max(CONCAT(FUN.fun_nom,' ',FUN.fun_ape)) as nombres,max(to_char(SAL.sal_fecha,'dd/mm/yyyy')) as sal_fecha,
                    max(cat.cat_nom) as sueldobruto,max(SAL.sal_ips) as sal_ips,max(SAL.sal_aus) as sal_aus,max(SAL.sal_pyt) as sal_pyt,max(SAL.sal_jud) as sal_jud,max(SAL.sal_aso) as sal_aso,max(SAL.sal_rep)as sal_rep,sum(DES.ode_mon) as ode_mon,'Otros Descuentos' as tde_des,max(SAL.sal_neto) as sal_neto 
                   ,(max(SAL.sal_ips)+ max(SAL.sal_aus)+max(SAL.sal_pyt)+max(SAL.sal_jud)+max(SAL.sal_aso)+max(SAL.sal_rep)) as total_descuentos from Salario SAL
                    LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
                    LEFT OUTER JOIN tipo_descuento TIPDES
                    on TIPDES.tde_cod=DES.tde_cod
                    INNER JOIN funcionario FUN 
                    on SAl.fun_cod=FUN.fun_cod
                    INNER JOIN categoria_detalle catdet
                    on sal.fun_cod= catdet.fun_cod
                    INNER JOIN categoria cat
                    on cat.cat_cod=catdet.cat_cod
                    where SAL.fun_cod=FUN.fun_cod and FUN.fun_ci='$nroci' 
                    and SAL.sal_fecha between '$desdefecha' and '$hastafecha' 
                    group by SAL.sal_fecha
                    order by SAL.sal_fecha");
 
$numregs=pg_numrows($consulta);

//Build table
$fill=false;
$i=0;
while($i<$numregs)
{
    
    $item=pg_result($consulta,$i,'lineas');
    $funcionario=pg_result($consulta,$i,'nombres');
    $fecha=pg_result($consulta,$i,'sal_fecha');
    $sueldobruto=pg_result($consulta,$i,'sueldobruto');
    $IPS=pg_result($consulta,$i,'sal_ips');
    $Ausencia=pg_result($consulta,$i,'sal_aus');
    $Permiso=pg_result($consulta,$i,'sal_pyt');
    $Judicial=pg_result($consulta,$i,'sal_jud');
    $ASO=pg_result($consulta,$i,'sal_aso');
    $Reposo=pg_result($consulta,$i,'sal_rep');
    $Odescuentos=pg_result($consulta,$i,'ode_mon');
    $Neto=pg_result($consulta,$i,'sal_neto');
    
    
     
    $pdf->Cell(15,10,$item,1,0,'C',$fill);
    $pdf->Cell(55,10,$funcionario,1,0,'L',$fill);
    $pdf->Cell(20,10,$fecha,1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($sueldobruto, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($IPS, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($Ausencia, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($Permiso, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($Judicial, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($ASO, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($Reposo, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(30,10,number_format($Odescuentos, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(30,10,number_format($Neto, 0, '', '.'),1,1,'C',$fill);
    $fill=!$fill;
    $i++;
}
/*
 * 
 * 
 * Aqui haremos las consultas para los totales
 * 
 * 
 */
$pdf->SetFont('Arial','B',12);
$consulta2=pg_exec($conectate,"SELECT '    ' as lineas, 
    'TOTALES'  as nombres,
    '        ' as sal_fecha, 
    'SUMAS TOTALES' as tde_des,
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
    where SAL.fun_cod=FUN.fun_cod and FUN.fun_ci='$nroci' 
    and SAL.sal_fecha between '$desdefecha' and '$hastafecha' ");

$numregs2=pg_numrows($consulta2);

//Build table
$fill=false;
$i=0;
while($i<$numregs2)
{
    
    $itemT=pg_result($consulta2,$i,'lineas');
    $funcionarioT=pg_result($consulta2,$i,'nombres');
    $fechaT=pg_result($consulta2,$i,'sal_fecha');
    $IPST=pg_result($consulta2,$i,'ips');
    $AusenciaT=pg_result($consulta2,$i,'ausencia');
    $PermisoT=pg_result($consulta2,$i,'permiso');
    $JudicialT=pg_result($consulta2,$i,'judicial');
    $ASOT=pg_result($consulta2,$i,'aso');
    $ReposoT=pg_result($consulta2,$i,'reposo');
    $OdescuentosT=pg_result($consulta2,$i,'descuentos');
    $NetoT=pg_result($consulta2,$i,'totalneto');
    
    
     
    $pdf->Cell(15,10,$itemT,1,0,'C',$fill);
    $pdf->Cell(55,10,$funcionarioT,1,0,'L',$fill);
    $pdf->Cell(20,10,$fechaT,1,0,'C',$fill);
    $pdf->Cell(25,10,'Sueldo bruto',1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($IPST, 0, '', '.'),1,0,'L',$fill);
    $pdf->Cell(25,10,number_format($AusenciaT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($PermisoT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($JudicialT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($ASOT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($ReposoT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(30,10,number_format($OdescuentosT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(30,10,number_format($NetoT, 0, '', '.'),1,1,'C',$fill);
    $fill=!$fill;
    $i++;
}






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
$pdf->Output();
$pdf->Close();
?>