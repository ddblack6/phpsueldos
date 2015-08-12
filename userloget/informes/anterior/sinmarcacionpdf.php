<?
include ('class.ezpdf.php');
$connection_string = 'DRIVER={SQL Server};SERVER=INTN23\SQLEXPRESS;DATABASE=att';
$user = 'sa'; 
$pass = 'caraplana';
$conn = odbc_connect( $connection_string, $user, $pass );
if (!$conn) {
	exit("Conexion Fallada: " . $conn);
}
//no es del pdf
	$nro20=$_POST['nro20'];	
	$consulta="select min(deptid)as desde,Max(deptid)as hasta from DEPARTMENTS where SUPDEPTID=".$nro20;
	$resulte = odbc_exec($conn,$consulta);
	while(odbc_fetch_row($resulte))
		{
		$desde=odbc_result($resulte,1);
		$hasta=odbc_result($resulte,2);
		}
//no es del pdf
$pdf =& new Cezpdf('a4','landscape'); // Tamaño de hoja y orientacion:'portrait'=vert;'landscape'=hori
$pdf->selectFont('/fonts/courier.afm'); //Fuentes
$pdf->ezSetCmMargins(1,1,1.5,1.5); //Margenes (top,bottom,left,right)
$pdf->ezStartPageNumbers(810,29,10,'','Pagina : {PAGENUM} de {TOTALPAGENUM}',1);

$fechs = date("d-m-Y H:i:s");
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,40,820,40);//inicio,ubicacion izquierda,fin,ubicacion derecha
$pdf->line(20,550,820,550);//inicio,ubicacion izquierda,fin,ubicacion derecha
$pdf->addText(55,553,10,'Instituto Nacional de Tecnologia, Normalizacion y Metrologia');
$pdf->addText(645,553,10,'Sistema - Consulta de Marcación');
$pdf->addText(20,29,10,'Generado el: '.$fechs);
$pdf->addJpegFromFile("/img/INTN.jpg",20,553,30,30);
$pdf->restoreState();
$pdf->closeObject();
// termina las lineas
$pdf->addObject($all,'all');
//--------
/*
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("trabajo", $conexion);
$result=mysql_query("SELECT * FROM departamento",$conexion)or die(mysql_error());*/ //obtener los datos a listar

//Consulta desde aqui
	$fecdes=$_POST['fecdes'];
	$fechas=$_POST['fechas'];
	if(($_POST['tipfun'])==1){
	$query = 
	"with 
	tempa As(Select Row_Number() Over (partition by convert(date,checktime) Order By userid) As [rid],
		userid,convert(date,checktime) as fecha, left(convert(time,checktime),8)as checktimes
		From dbo.CHECKINOUT 
		where CONVERT(date,checktime)>='".$fecdes."' and CONVERT(date,checktime)<='".$fechas."'),
	
	tempe as(Select Row_Number() Over (partition by convert(date,checktime) Order By userid) As [rid],
		userid,convert(date,checktime) as fecha, left(convert(time,checktime),8)as checktimes
		From dbo.CHECKINOUT 
		where CONVERT(date,checktime)>='".$fecdes."' and CONVERT(date,checktime)<='".$fechas."'),

	tempd as (select deptid,deptname,supdeptid from DEPARTMENTS where DEPTID=".$desde."), --aqui debo cambiar
	
	temp as	(select DEPTID,DEPTNAME from DEPARTMENTS where SUPDEPTID<=1),
	
	depen as (select h.deptid,h.deptname,h.supdeptid,j.deptname as det from tempd h,temp j	where h.supdeptid=j.deptid),

	permi as(select s.USERID,CONVERT(date,s.STARTSPECDAY)as fecha,left(CONVERT(time,s.STARTSPECDAY),5)as desde,
		left(CONVERT(time,s.ENDSPECDAY),5)as hasta,l.leavename as motivo,s.DATE as registrado 
		from USER_SPEDAY s, LeaveClass l
		where s.DATEID=l.LeaveId and DATEPART(year,s.STARTSPECDAY)=DATEPART(year,GETDATE()) and
			CONVERT(date,s.STARTSPECDAY)>='".$fecdes."' and	CONVERT(date,s.STARTSPECDAY)<='".$fechas."'),
			
	rony2 as (select u.userid,u.badgenumber,u.ssn,u.name,a.fecha,p.deptname,p.det,
		entrada= case when (left(convert(time,min(a.checktimes)),4)=left(convert(time,max(a.checktimes)),4) and 
		left(convert(time,min(a.checktimes)),8)>='13:00:00') then null else min(a.checktimes) end,
		salida=case when (left(convert(time,min(a.checktimes)),4)=left(convert(time,max(a.checktimes)),4) and 
		left(convert(time,max(a.checktimes)),8)<='13:00:00')then null else max(a.checktimes) end --, d.DEPTNAME as dependencia
		from tempa a,tempe b,USERINFO u,depen p,DEPARTMENTS d
		where a.fecha=b.fecha and u.userid=a.userid and u.DEFAULTDEPTID=p.DEPTID 
			and u.DEFAULTDEPTID=d.DEPTID
		group by u.userid,u.badgenumber,u.ssn,u.name,a.fecha,p.deptname,p.det)
select * from rony2 w
left join permi x
on w.userid=x.userid and w.fecha=x.fecha
where entrada >='07:11:00' and entrada <'07:31:00'";

	}else{
	$query =
	"with 
	tempa As(Select Row_Number() Over (partition by convert(date,checktime) Order By userid) As [rid],
		userid,convert(date,checktime) as fecha, left(convert(time,checktime),8)as checktimes
		From dbo.CHECKINOUT 
		where CONVERT(date,checktime)>='".$fecdes."' and CONVERT(date,checktime)<='".$fechas."'),
	
	tempe as(Select Row_Number() Over (partition by convert(date,checktime) Order By userid) As [rid],
		userid,convert(date,checktime) as fecha, left(convert(time,checktime),8)as checktimes
		From dbo.CHECKINOUT 
		where CONVERT(date,checktime)>='".$fecdes."' and CONVERT(date,checktime)<='".$fechas."'),

	tempd as (select deptid,deptname,supdeptid from DEPARTMENTS where DEPTID=".$hasta."), --aqui debo cambiar
	
	temp as	(select DEPTID,DEPTNAME from DEPARTMENTS where SUPDEPTID<=1),
	
	depen as (select h.deptid,h.deptname,h.supdeptid,j.deptname as det from tempd h,temp j	where h.supdeptid=j.deptid),

	permi as(select s.USERID,CONVERT(date,s.STARTSPECDAY)as fecha,left(CONVERT(time,s.STARTSPECDAY),5)as desde,
		left(CONVERT(time,s.ENDSPECDAY),5)as hasta,l.leavename as motivo,s.DATE as registrado 
		from USER_SPEDAY s, LeaveClass l
		where s.DATEID=l.LeaveId and DATEPART(year,s.STARTSPECDAY)=DATEPART(year,GETDATE()) and
			CONVERT(date,s.STARTSPECDAY)>='".$fecdes."' and	CONVERT(date,s.STARTSPECDAY)<='".$fechas."'),
			
	rony2 as (select u.userid,u.badgenumber,u.ssn,u.name,a.fecha,p.deptname,p.det,
		entrada= case when (left(convert(time,min(a.checktimes)),4)=left(convert(time,max(a.checktimes)),4) and 
		left(convert(time,min(a.checktimes)),8)>='13:00:00') then null else min(a.checktimes) end,
		salida=case when (left(convert(time,min(a.checktimes)),4)=left(convert(time,max(a.checktimes)),4) and 
		left(convert(time,max(a.checktimes)),8)<='13:00:00')then null else max(a.checktimes) end --, d.DEPTNAME as dependencia
		from tempa a,tempe b,USERINFO u,depen p,DEPARTMENTS d
		where a.fecha=b.fecha and u.userid=a.userid and u.DEFAULTDEPTID=p.DEPTID 
			and u.DEFAULTDEPTID=d.DEPTID
		group by u.userid,u.badgenumber,u.ssn,u.name,a.fecha,p.deptname,p.det)
select * from rony2 w
left join permi x
on w.userid=x.userid and w.fecha=x.fecha
where entrada >='07:11:00' and entrada <'07:31:00'";
	}
	/*$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("trabajo", $conexion);
$result=mysql_query("SELECT * FROM departamento",$conexion)or die(mysql_error());*/ //obtener los datos a listar
  $result = odbc_exec($query,$conn);
//Consulta hasta aqui


while($datatmp = odbc_fetch_row($result)) {
	$data[] = $datatmp;
}
$titles = array( //Los campos y sus respectivos encabezados
	/*'badgenumber'=>'Expediente',
	'ssn'=>'Documento',
	'name'=>'Nombre y Apellido',
	'fecha'=>'Fecha',
	'entrada'=>'Entrada'*/
	odbc_result($result,2)=>'Expediente'
);
$options = array( 
	'showHeadings'=>1, //mostrar titulo =1; Ocultar titulo =0
	'shadeCol'=>array(0.9,0.9,0.9), //color en RGB
	'xOrientation'=>'center', //alineacion
	//'width'=>350 //ancho de tabla
);

$txttitle = "\n\n DETALLLE DE MARCACIONES "."\n"; //Titulo general
$pdf->ezText($txttitle, 12,array('justification'=>'center'));
$pdf->ezTable($data,$titles, '', $options);
//$pdf->ezText("\n\n\n", 8);
$pdf->ezStream();

?>