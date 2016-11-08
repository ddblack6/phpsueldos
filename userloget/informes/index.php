<?php
require('access.php');
$connection_string = 'DRIVER={SQL Server};SERVER=INTN23\SQLEXPRESS;DATABASE=att';
$user = 'sa'; 
$pass = 'caraplana';
$conn=odbc_connect( $connection_string, $user, $pass );
if(!$conn)
    die('Connection failed');
$pdf=new PDF('P','mm','A4'); //'P'=vertical o 'L'=horizontal,'mm','A4' o 'Legal'

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->Cell(150,10,'Aqui va el Titulo',100,100,'C');//Titulo
$pdf->SetFont('Arial','',10);
$col=array('userid'=>12, 'ssn'=>20, 'name'=>80);
$pdf->Table($sql,$col);
$pdf->Output();
?>