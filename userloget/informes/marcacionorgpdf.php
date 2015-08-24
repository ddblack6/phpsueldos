<?php
require('fpdf.php');

class PDF extends FPDF
{
function Table($sql,$col)
{
    global $conn;
$connection_string = 'DRIVER={SQL Server};SERVER=INTN23\SQLEXPRESS;DATABASE=att';
$user = 'sa'; 
$pass = 'caraplana';
    //Query
	/*$desde=$_GET['desde'];
	$hasta=$_GET['hasta'];
	$fecdes=$_GET['fecdes'];
	$fechas=$_GET['fechas'];*/
	$query = "select car_cod, car_des from cargo";

	$res= odbc_connect( $connection_string, $user, $pass );
    if(!$res)
        die('SQL error');

    //Header
    $this->SetFillColor(129,159,247);
    $this->SetTextColor(255);
    $this->SetDrawColor(14,72,245);
    $this->SetLineWidth(.4);
    $this->SetFont('','B');
    $tw=0;
    foreach($col as $label=>$width)
    {
        $tw+=$width;
        $this->Cell($width,7,$label,1,0,'C',1);
    }
    $this->Ln();

    //Rows
	$res = odbc_exec($conn,$query);
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    $fill=false;
    while(odbc_fetch_row($res))
    {
        foreach($col as $field=>$width)
            $this->Cell($width,6,odbc_result($res,$field),'LR',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell($tw,0,'','T');
}
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
	$this->Cell(0,10,'P�gina: '.$this->PageNo().' de {nb}',0,0,'R');
	$this->text(10,207,'Consulta Generada: '.date('d-M-Y').' '.date('h:i:s'));
}
function Header()
{
    // Select Arial bold 15
    $this->SetFont('Arial','',9);
	$this->Image('img/intn.jpg',10,4,-300);
    // Move to the right
    $this->Cell(80);
    // Framed title
	$this->text(25,22,'Instituto Nacional de Tecnolog�a, Normalizaci�n y Metrolog�a');
	$this->text(296,22,'Sistema - Consulta de Marcaci�n');
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(20);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(343,23,9,23);//largor,ubicacion derecha,inicio,ubicacion izquierda
}
}

$str_conexao='dbname=contabilidade port=5434 user=postgres password=postgres';
$conexao=pg_connect($str_conexao) or die('A conex�o ao banco de dados falhou!');
$consulta=pg_exec($conexao,'select * from conveniologin');
$numregs=pg_numrows($consulta);

$connection_string = 'dbname=salario port=5434 user=postgres password=postgres';
$conn=pg_connect($connection_string) or die('La conexion a la base de datos a fallado!');
//Aqui la segunda parte
$connection_string = 'DRIVER={SQL Server};SERVER=INTN23\SQLEXPRESS;DATABASE=att';
$user = 'sa'; 
$pass = 'caraplana';
$conn=odbc_connect( $connection_string, $user, $pass );
if(!$conn)
    die('Connection failed');
	
	
	
	
	
$pdf=new PDF('L','mm','Legal'); //'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->Cell(350,10,'Marcaci�n de Funcionario por Organismo',100,100,'C');//Titulo
$pdf->SetFont('Arial','',10);
$col=array('badgenumber'=>15, 'ssn'=>20, 'name'=>58, 'fecha'=>22, 'entrada'=>17, 
		'salida'=>17, 'deptname'=>32, 'det'=>30, 'desde'=>13, 'hasta'=>13, 'motivo'=>48, 'registrado'=>43);
$pdf->Table($sql,$col);
$pdf->Output();
?>