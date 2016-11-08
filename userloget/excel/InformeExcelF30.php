<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('Contacte con el Programador del Sistema');

/** Include PHPExcel */
require_once dirname(__FILE__) .'/PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Marcos Riveros")
							 ->setLastModifiedBy("Marcos Riveros")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

//Estos seran las cabeceras de mi archivo excel
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Item')
            ->setCellValue('B1', 'Nro Linea')
            ->setCellValue('C1', 'Cargo')
            ->setCellValue('D1', 'Nro CI')
            ->setCellValue('E1', 'Funcionario')
            ->setCellValue('F1', 'Categoria')
            ->setCellValue('G1', 'Sueldo Bruto')
            ->setCellValue('H1', 'IPS')
            ->setCellValue('I1', 'Ausencia')
            ->setCellValue('J1', 'Permisos')
            ->setCellValue('K1', 'Judicial')
            ->setCellValue('L1', 'ASO')
            ->setCellValue('M1', 'Reposo')
            ->setCellValue('N1', 'Total Descuentos')
            ->setCellValue('O1', 'Neto a Cobrar');
//aqui ingresare mi consulta y mis valores
$conectate=pg_connect("host=192.168.0.18 port=5432 dbname=salario2016 user=postgres password=postgres_server"
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"SELECT row_number()over (partition by 0 order by max(cat.cat_cod) ) as lineas,
                    max(Sal.usu_cod) as usu_cod
                    ,max(FUN.fun_ci)as fun_ci
                    ,max(Sal.sal_cod)as sal_cod
                    ,max(Sal.fun_cod) as fun_cod
                    ,max(org.org_cod) as organismo
                    ,max(CONCAT(FUN.fun_nom,' ',FUN.fun_ape)) as nombres
                    ,max(to_char(SAL.sal_fecha,'dd/mm/yyyy')) as sal_fecha
                    ,COALESCE(max(cat.cat_nom),0) as sueldobruto
                    ,COALESCE(max(SAL.sal_ips),0) as sal_ips
                    ,COALESCE(max(SAL.sal_aus),0) as sal_aus
                    ,COALESCE(max(SAL.sal_pyt),0) as sal_pyt
                    ,COALESCE(max(SAL.sal_jud),0) as sal_jud
                    ,COALESCE(max(SAL.sal_aso),0) as sal_aso
                    ,COALESCE(max(SAL.sal_rep),0)as sal_rep
                    ,COALESCE(sum(DES.ode_mon),0) as ode_mon
                    ,'Otros Descuentos' as tde_des
                    ,COALESCE(max(SAL.sal_neto),0) as sal_neto 
					,COALESCE((max(SAL.sal_ips)+ max(SAL.sal_aus)+max(SAL.sal_pyt)+max(SAL.sal_jud)+max(SAL.sal_aso)+max(SAL.sal_rep)),0) as total_descuentos
					,max(car.car_des) as cargo
					,max(cat.cat_des) as categoria
					,max(lin.lin_des) as nrolinea
                    from Salario SAL
                    LEFT OUTER JOIN descuento DES on (DES.sal_cod=SAL.sal_cod)  
                    LEFT OUTER JOIN tipo_descuento TIPDES
                    on TIPDES.tde_cod=DES.tde_cod
                    INNER JOIN funcionario FUN 
                    on SAl.fun_cod=FUN.fun_cod
                    INNER JOIN categoria_detalle catdet
                    on sal.fun_cod= catdet.fun_cod
                    INNER JOIN categoria cat
                    on cat.cat_cod=catdet.cat_cod
                    INNER JOIN organismo_detalle orgdet
                    on sal.fun_cod= orgdet.fun_cod
                    INNER JOIN organismo org
                    on org.org_cod=orgdet.org_cod
                    INNER JOIN cargo car
                    on car.car_cod=FUN.car_cod
                    INNER JOIN linea_detalle lindet
                    on sal.fun_cod= lindet.fun_cod
                    INNER JOIN linea lin
                    on lin.lin_cod=lindet.lin_cod
                    where SAL.fun_cod=FUN.fun_cod and FUN.fun_fuente='30' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())  
                    group by FUN.fun_cod 
                    order by nrolinea,nombres");
$numregs=pg_numrows($consulta);
//Build table
$i=0;
$j=2;
while($i<$numregs)
{
    $cargo=pg_result($consulta,$i,'cargo');
    $cedula=pg_result($consulta,$i,'fun_ci');
    $categria=pg_result($consulta,$i,'categoria');
    $nrolinea=pg_result($consulta,$i,'nrolinea');
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
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$j, $i+1)
            ->setCellValue('B'.$j, $nrolinea)
            ->setCellValue('C'.$j, $cargo)
            ->setCellValue('D'.$j, $cedula)
            ->setCellValue('E'.$j, $funcionario)
            ->setCellValue('F'.$j, $categria)
            ->setCellValue('G'.$j, $sueldobruto)
            ->setCellValue('H'.$j, $IPS)
            ->setCellValue('I'.$j, $Ausencia)
            ->setCellValue('J'.$j, $Permiso)
            ->setCellValue('K'.$j, $Judicial)
            ->setCellValue('L'.$j, $ASO)
            ->setCellValue('M'.$j, $Reposo)
            ->setCellValue('N'.$j, $IPS+$Ausencia+$Permiso+$Judicial+$ASO+$Reposo+$Odescuentos)
            ->setCellValue('O'.$j, $Neto);
    $i++;
    $j++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ResumenFuente30.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
ob_end_clean();
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;
