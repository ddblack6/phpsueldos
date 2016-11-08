<html><head><title>Informe- Cargos</title></head><body></body></html>
            
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
$pdf->SetMargins(100, 25 , 30); 
$pdf->AddPage('L', 'Legal');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',16);
$pdf->SetTitle('LISTADO DE LOS CARGOS');
$pdf->Cell(150,10,'Listado de Cargos',100,100,'C');//Titulo

//Set font and colors

$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(153,192,141);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(153,192,141);
$pdf->SetLineWidth(.3);


//Table header
/*$pdf->Cell(20,10,'SIAPE',1,0,'L',1);
$pdf->Cell(50,10,'Nome',1,1,'L',1);*/

$pdf->Cell(70,10,'Codigo',1,0,'C',1);
$pdf->Cell(70,10,'Detalle',1,1,'C',1);

//Restore font and colors
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);

//Connection and query
$pregunta='dbname=dbsalario port=5432 user=postgres password=postgres_server';
$conectate=pg_connect("host=192.168.0.18 port=5432 dbname=salario user=postgres password=postgres_server"
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,'select car_cod,car_des from cargo');
$numregs=pg_numrows($consulta);

//Build table
$fill=false;
$i=0;
while($i<$numregs)
{
    
    $codigo=pg_result($consulta,$i,'car_cod');
    $descripcion=pg_result($consulta,$i,'car_des');
    $pdf->Cell(70,10,$codigo,1,0,'C',$fill);
    $pdf->Cell(70,10,$descripcion,1,1,'L',$fill);
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