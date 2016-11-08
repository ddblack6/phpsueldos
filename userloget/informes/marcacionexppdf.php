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
	
	$fecdes=$_GET['fecdes'];
	$fechas=$_GET['fechas'];
	$nrouser=$_GET['nrouser'];	
	$query = 
	"with 
	tempa As(Select Row_Number() Over (partition by convert(date,checktime) Order By userid) As [rid],
		userid,convert(date,checktime) as fecha, left(convert(time,checktime),8)as checktimes
		From dbo.CHECKINOUT 
		where CONVERT(date,checktime)>='".$fecdes."' and CONVERT(date,checktime)<='".$fechas."' and userid=".$nrouser."),
	
	tempe as(Select Row_Number() Over (partition by convert(date,checktime) Order By userid) As [rid],
		userid,convert(date,checktime) as fecha, left(convert(time,checktime),8)as checktimes
		From dbo.CHECKINOUT 
		where CONVERT(date,checktime)>='".$fecdes."' and CONVERT(date,checktime)<='".$fechas."' and userid=".$nrouser."),

	tempd as (select deptid,deptname,supdeptid from DEPARTMENTS), --aqui debo cambiar
	
	temp as	(select DEPTID,DEPTNAME from DEPARTMENTS where SUPDEPTID<=1),
	
	depen as (select h.deptid,h.deptname,h.supdeptid,j.deptname as det from tempd h,temp j	where h.supdeptid=j.deptid),

	permi as(select s.USERID,CONVERT(date,s.STARTSPECDAY)as fecha,left(CONVERT(time,s.STARTSPECDAY),5)as desde,
		left(CONVERT(time,s.ENDSPECDAY),5)as hasta,l.leavename as motivo,s.DATE as registrado 
		from USER_SPEDAY s, LeaveClass l
		where s.DATEID=l.LeaveId and DATEPART(year,s.STARTSPECDAY)=DATEPART(year,GETDATE()) and
			CONVERT(date,s.STARTSPECDAY)>='".$fecdes."' and	CONVERT(date,s.STARTSPECDAY)<='".$fechas."' and s.userid=".$nrouser."),
			
	rony2 as (select u.userid,u.badgenumber,u.ssn,u.name,a.fecha,p.deptname,p.det,
		entrada= case when (left(convert(time,min(a.checktimes)),4)=left(convert(time,max(a.checktimes)),4) and 
		left(convert(time,min(a.checktimes)),8)>='13:00:00') then null else min(a.checktimes) end,
		salida=case when (left(convert(time,min(a.checktimes)),4)=left(convert(time,max(a.checktimes)),4) and 
		left(convert(time,max(a.checktimes)),8)<='13:00:00')then null else max(a.checktimes) end --, d.DEPTNAME as dependencia
		from tempa a,tempe b,USERINFO u,depen p,DEPARTMENTS d
		where a.fecha=b.fecha and u.userid=a.userid and u.DEFAULTDEPTID=p.DEPTID 
			and u.DEFAULTDEPTID=d.DEPTID and u.userid=".$nrouser."
		group by u.userid,u.badgenumber,u.ssn,u.name,a.fecha,p.deptname,p.det)
	select * from rony2 w
	left join permi x
	on w.userid=x.userid and w.fecha=x.fecha";

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
	$this->Cell(0,10,'Página: '.$this->PageNo().' de {nb}',0,0,'R');
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
	$this->text(25,22,'Instituto Nacional de Tecnología, Normalización y Metrología');
	$this->text(296,22,'Sistema - Consulta de Marcación');
	//$this->Cell(30,10,'noc',0,0,'C');
    // Line break
    $this->Ln(20);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.2);
	$this->Line(343,23,9,23);//largor,ubicacion derecha,inicio,ubicacion izquierda
}
}
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
$pdf->Cell(350,10,'Marcación de Funcionario por Expediente',100,100,'C');//Titulo
$pdf->SetFont('Arial','',10);
$col=array('badgenumber'=>15, 'ssn'=>20, 'name'=>58, 'fecha'=>22, 'entrada'=>17, 
		'salida'=>17, 'deptname'=>32, 'det'=>30, 'desde'=>13, 'hasta'=>13, 'motivo'=>48, 'registrado'=>43);
$pdf->Table($sql,$col);
$pdf->Output();
?>