<?php
//Example FPDF script with PostgreSQL
//Ribamar FS - ribafs@dnocs.gov.br

require('fpdf.php');

class PDF extends FPDF{
function Footer()
{
        
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(343,236,15,236);//largor,ubicacion derecha,inicio,ubicacion izquierda
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
    if  (empty($_COOKIE["Organismo"])){
     $Organismo=0;    
 }  else
 {
     if  (empty($_POST['txtFecha'])){$fechaCabecera=0;}else{$fechaCabecera=$_POST['txtFecha'];}
     $mes=substr($fechaCabecera, 5, 2);
     $mesTex=genMonth_Text($mes);
     $anhoText=substr($fechaCabecera, 0, 4);
     $Organismo = $_COOKIE["Organismo"];
     setcookie("Organismo", $_COOKIE["Organismo"], time()+12);
 }
 if  (empty(  $_POST['txtRadioFuente'])){$fuente='30 Recursos Institucionales' ;}else{$fuente= '10 Recursos del Tesoro';}
 
 if ($Organismo=='Administracion')
 {
     $Programa='01 Programa de Administracion';    
     }else
     {
         $Programa='02 Programa de Accion';
    }
   // Select Arial bold 15
    $this->SetFont('Arial','',9);
	$this->Image('img/intn.jpg',15,10,-300,0,'','../../InformeCargos.php');
    // Move to the right
    $this->Cell(80);
    // Framed title
	$this->text(15,32,utf8_decode('Instituto Nacional de Tecnología, Normalización y Metrología'));
	$this->text(315,32,'Sistema - Sueldos');
        $this->text(315,37,'Sueldo Mes: '.utf8_decode(genMonth_Text($mes).' Año: '.$anhoText));
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(30);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(360 ,33,10,33);//largor,ubicacion derecha,inicio,ubicacion izquierda
//table header        
    
    $this->SetFont('Arial','B',8);
    $this->SetTitle('LISTADO DE SUELDOS');
    $this->Cell(120,5,'Organismo: 23 Entes Autonomos y Autarquicos',100,100,'L');//Titulo
    $this->Cell(120,5,'Entidad: 01 Instituto Nacional de Tecnologia Normalizacion y Metrologia',100,100,'L');//Titulo
    $this->Cell(120,5,'Tipo de Presupuesto: '.$Programa,100,100,'L');//Titulo
    $this->Cell(120,5,'Programa: '.$Organismo,100,100,'L');//Titulo
    $this->Cell(120,5,'Objeto del Gasto: 111 Sueldos',100,100,'L');//Titulo
    $this->Cell(120,5,'Fuente del Financiamiento: '.$fuente,100,100,'L');//Titulo    
    $this->SetFillColor(153,192,141);
    $this->SetTextColor(255);
    $this->SetDrawColor(153,192,141);
    $this->SetLineWidth(.3);
    /*$this->Cell(20,10,'SIAPE',1,0,'L',1);
    $this->Cell(50,10,'Nome',1,1,'L',1);*/
    
  $this->Cell(15,10,'Item',1,0,'C',1);
    $this->Cell(13,10,'Nro Linea',1,0,'C',1);
    $this->Cell(45,10,'Cargo',1,0,'C',1);
    $this->Cell(15,10,'Nro CI',1,0,'C',1);
    $this->Cell(57,10,'Funcionario',1,0,'C',1);
    $this->Cell(15,10,'Categoria',1,0,'C',1);
    $this->Cell(20,10,'Sueldo Bruto',1,0,'C',1);
    $this->Cell(15,10,'IPS',1,0,'C',1);
    $this->Cell(20,10,'Ausencia',1,0,'C',1);
    $this->Cell(20,10,'Permisos',1,0,'C',1);
    $this->Cell(20,10,'Judicial',1,0,'C',1);
    $this->Cell(20,10,'ASO',1,0,'C',1);
    $this->Cell(20,10,'Reposo',1,0,'C',1);
    $this->Cell(25,10,'Total Descuentos',1,0,'C',1);
    $this->Cell(25,10,'Neto a Cobrar',1,1,'C',1);
//Restore font and colors


}
}

$pdf=new PDF();//'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'
//obtener el nombre de organismo------------------------------------------------
//QUERY and data cargue y se reciben los datos
if  (empty($_POST['txtNombreOrganismo'])){$codigo=0;}else{$codigo=$_POST['txtNombreOrganismo'];}
if  (empty($_POST['txtFecha'])){$fecha=0;}else{$fecha=$_POST['txtFecha'];}
if  (empty(  $_POST['txtRadioFuente'])){$fuenteNumero='30' ;}else{$fuenteNumero= '10';}
  $mes=substr($fecha, 5, 2);
//------------------------------------------------------------------------------      
$pdf->AddPage('L', 'Legal');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',10);


//Set font and colors




$conectate=pg_connect("host=192.168.0.99 port=5432 dbname=salario user=postgres password=postgres"
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"SELECT row_number()over (partition by 0 order by max(SAL.sal_cod)) as lineas,
                    max(Sal.usu_cod) as usu_cod,max(Sal.sal_cod)as sal_cod,max(Sal.fun_cod) as fun_cod,max(CONCAT(FUN.fun_nom,' ',FUN.fun_ape)) as nombres,max(to_char(SAL.sal_fecha,'dd/mm/yyyy')) as sal_fecha,
                    max(cat.cat_nom) as sueldobruto,max(SAL.sal_ips) as sal_ips,max(SAL.sal_aus) as sal_aus,max(SAL.sal_pyt) as sal_pyt,max(SAL.sal_jud) as sal_jud,max(SAL.sal_aso) as sal_aso,max(SAL.sal_rep)as sal_rep,sum(DES.ode_mon) as ode_mon,'Otros Descuentos' as tde_des,max(SAL.sal_neto) as sal_neto 
                    ,max(ORG.org_des)as organismo 
                    ,max(car.car_des) as cargo
                    ,max(FUN.fun_ci)as fun_ci
                    ,max(cat.cat_des) as categoria
                    ,max(lin.lin_des) as nrolinea
                    from Salario SAL
                    LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
                    LEFT OUTER JOIN tipo_descuento TIPDES
                    on TIPDES.tde_cod=DES.tde_cod
                    INNER JOIN funcionario FUN 
                    on SAl.fun_cod=FUN.fun_cod
                    INNER JOIN organismo_detalle ORGDET
                    on ORGDET.fun_cod=FUN.fun_cod
                    INNER JOIN organismo ORG
                    on ORG.org_cod=ORGDET.org_cod
                    INNER JOIN categoria_detalle catdet
                    on sal.fun_cod= catdet.fun_cod
                    INNER JOIN categoria cat
                    on cat.cat_cod=catdet.cat_cod
                    INNER JOIN cargo car
                    on car.car_cod=FUN.car_cod
                     INNER JOIN linea_detalle lindet
                    on sal.fun_cod= lindet.fun_cod
                    INNER JOIN linea lin
                    on lin.lin_cod=lindet.lin_cod
                    where SAL.fun_cod=FUN.fun_cod 
                    and ORG.org_cod='$codigo'
                    and FUN.fun_fuente= '$fuenteNumero'
                    and EXTRACT(MONTH FROM sal_fecha)=$mes
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now()) 
                    group by FUN.fun_cod order by nrolinea,FUN.fun_nom");

$numregs=pg_numrows($consulta);
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
//Build table
$fill=false;
$i=0;
while($i<$numregs)
{
    
    $nrolinea=pg_result($consulta,$i,'nrolinea');
    $cargo=pg_result($consulta,$i,'cargo');
    $cedula=pg_result($consulta,$i,'fun_ci');
    $categria=pg_result($consulta,$i,'categoria');
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
    
   
     
     $pdf->Cell(15,5,$i+1,1,0,'C',$fill);
    $pdf->Cell(13,5,number_format($nrolinea, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(45,5,$cargo,1,0,'C',$fill);
    $pdf->Cell(15,5,$cedula,1,0,'C',$fill);
    $pdf->Cell(57,5,$funcionario,1,0,'L',$fill);
    $pdf->Cell(15,5,utf8_decode($categria),1,0,'C',$fill);
    $pdf->Cell(20,5,number_format($sueldobruto, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(15,5,number_format($IPS, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,5,number_format($Ausencia, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,5,number_format($Permiso, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,5,number_format($Judicial, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,5,number_format($ASO, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,5,number_format($Reposo, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,5,number_format($IPS+$Ausencia+$Permiso+$Judicial+$ASO+$Reposo+$Odescuentos, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,5,number_format($Neto, 0, '', '.'),1,1,'C',$fill);
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
$pdf->SetFont('Arial','B',8);
$consulta2=pg_exec($conectate,"SELECT '    ' as lineas, 
    'TOTALES'  as nombres,
    '        ' as sal_fecha, 
    'SUMAS TOTALES' as tde_des,
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
    LEFT OUTER JOIN tipo_descuento TIPDES
    on TIPDES.tde_cod=DES.tde_cod
    INNER JOIN funcionario FUN 
    on SAl.fun_cod=FUN.fun_cod
    INNER JOIN organismo_detalle ORGDET
    on ORGDET.fun_cod=FUN.fun_cod
    INNER JOIN organismo ORG
    on ORG.org_cod=ORGDET.org_cod
    INNER JOIN categoria_detalle catdet
    on sal.fun_cod= catdet.fun_cod
    INNER JOIN categoria cat
    on cat.cat_cod=catdet.cat_cod
    where SAL.fun_cod=FUN.fun_cod 
    and ORG.org_cod='$codigo'
	and FUN.fun_fuente= '$fuenteNumero'
    and EXTRACT(MONTH FROM sal_fecha)=$mes
    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now()) group by ORG.org_cod");

$numregs2=pg_numrows($consulta2);

//Build table
$fill=false;
$i=0;
while($i<$numregs2)
{
    $itemT=pg_result($consulta2,$i,'lineas');
    $funcionarioT=pg_result($consulta2,$i,'nombres');
    $fechaT=pg_result($consulta2,$i,'sal_fecha');
     $SueldoBrutoT=pg_result($consulta2,$i,'sueldobruto');
    $IPST=pg_result($consulta2,$i,'ips');
    $AusenciaT=pg_result($consulta2,$i,'ausencia');
    $PermisoT=pg_result($consulta2,$i,'permiso');
    $JudicialT=pg_result($consulta2,$i,'judicial');
    $ASOT=pg_result($consulta2,$i,'aso');
    $ReposoT=pg_result($consulta2,$i,'reposo');
    $OdescuentosT=pg_result($consulta2,$i,'descuentos');
    $TotaldescuentosT=pg_result($consulta2,$i,'totaldescuento');
    $NetoT=pg_result($consulta2,$i,'totalneto');
    
    
     
   $pdf->Cell(160,10,'SUMAS TOTALES',1,0,'C',$fill);
    $pdf->Cell(20,10,number_format($SueldoBrutoT, 0, '', '.'),1,0,'C',$fill); 
    $pdf->Cell(15,10,number_format($IPST, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,10,number_format($AusenciaT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,10,number_format($PermisoT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,10,number_format($JudicialT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,10,number_format($ASOT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(20,10,number_format($ReposoT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($IPST+$AusenciaT+$PermisoT+$JudicialT+$ReposoT+$ASOT+$OdescuentosT, 0, '', '.'),1,0,'C',$fill);
    $pdf->Cell(25,10,number_format($NetoT, 0, '', '.'),1,1,'C',$fill);
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
ob_end_clean();
$pdf->Output();
$pdf->Close();
// generamos los meses 
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