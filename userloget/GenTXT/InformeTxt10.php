<?php 
session_start();
?>
<html>
    <body>
        
   

<?php

/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */


$conectate=pg_connect("host=localhost port=5434 dbname=salario user=postgres password=postgres"
                    . "")or die ('Error al conectar a la base de datos');
$consulta=pg_exec($conectate,"SELECT row_number()over (partition by 0 order by max(cat.cat_cod) ) as lineas,
                    max(Sal.usu_cod) as usu_cod
                    ,max(FUN.fun_ci)as fun_ci
                    ,max(Sal.sal_cod)as sal_cod
                    ,max(Sal.fun_cod) as fun_cod
                    ,max(org.org_cod) as organismo
                    ,max(org.org_des) as organismodes
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
                    where SAL.fun_cod=FUN.fun_cod and FUN.fun_fuente='10' 
                    and EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now())
                    and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now())  
                    group by FUN.fun_cod 
                    order by nrolinea,nombres");
$numregs=pg_numrows($consulta);
//Build table
$i=0;
$j=2;
$dir='C:';
opendir($dir);
while($i<$numregs)
{
    
    $organismo=pg_result($consulta,$i,'organismodes');
    $cargo=pg_result($consulta,$i,'cargo');
    $cedula=pg_result($consulta,$i,'fun_ci');
    $categoria=pg_result($consulta,$i,'categoria');
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
   
    
   //Se procede a crear un archivo de texto y escribirl
    $ar=fopen("SueldosF10.txt","a") or
    die("Problemas en la creacion");
    //imprime 231 o 232 con un espacio 
    if($organismo=='Administracion')
    {
        fputs($ar,'231 ');
    }else{
        fputs($ar,'232 ');
    }
    //imprime el caracter 1 seguido del anho 
    fputs($ar,'1'.substr($fecha,6,4));
    //imprime el mes seguido del caracter P del protocolo
    fputs($ar,substr($fecha,3,2).'P                 ');
    //rellena hasta completar 15 espacios hacia la izquierda(no funca)
    $cedula=str_pad($cedula,15,' ',STR_PAD_LEFT);
    //imprime la cedula
    fputs($ar,$cedula);
    //imprime el caracter 0 obligatorio y la categoria
    fputs($ar,"   ");
    fputs($ar,"0");
    fputs($ar,$categoria);
    //imprime un espacio en blanco seguido del sueldo bruto
    fputs($ar," ".(int)$sueldobruto);
    //imprime un espacio en blanco seguido del sueldo bruto por segunda vez
    fputs($ar," ".(int)$sueldobruto);
    //hace 7 espacios, luego imprime el 0..despues 7 espacios y de nuevo el 0 y luego un espacio.
    fputs($ar,"       ");
    fputs($ar,"0");
    fputs($ar,"       ");
    fputs($ar,"0");
    fputs($ar," ");
    //imprime el sueldo neto
    fputs($ar,(int)$Neto);
    fputs($ar,"\n");
  
    $i++;
}
fclose($ar);
$file = "SueldosF10.txt";
header("Content-disposition: attachment; filename=\"$file\"");
header("Content-type: application/octet-stream");
readfile($file);
unlink('SueldosF10.txt');
?>
 </body>
</html>
