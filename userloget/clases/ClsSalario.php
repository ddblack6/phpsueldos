<!DOCTYPE html>
<!--
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        
            <?php
            //recupera los datos del form
            if  (empty($_POST['Nsal_cod'])){$codSalario=0;}else{$codSalario=$_POST['Nsal_cod'];}
          if  (empty($_POST['Nfun_cod'])){$codFuncionario=0;}else{$codFuncionario=$_POST['Nfun_cod'];}
          if  (empty($_POST['Nsal_pyt20'])){$salarioPyT20=0;}else{$salarioPyT20=$_POST['Nsal_pyt20'];}
          if  (empty($_POST['Nsal_pyt40'])){$salarioPyT40=0;}else{$salarioPyT40=$_POST['Nsal_pyt40'];}
          if  (empty($_POST['Nsal_pyt50'])){$salarioPyT50=0;}else{$salarioPyT50=$_POST['Nsal_pyt50'];}
          if  (empty($_POST['Nsal_aso'])){$ASO=0;}else{ $ASO = $_POST['Nsal_aso'];}
          if  (empty($_POST['Nsal_jud'])){$Judicial=0;}else{ $Judicial = $_POST['Nsal_jud'];}
          if  (empty($_POST['Nsal_aus'])){$Ausencia=0;}else{$Ausencia=$_POST['Nsal_aus'];}
          if  (empty($_POST['Nsal_ips'])){$IPS=0;}else{ $IPS= $_POST['Nsal_ips'];}
          if  (empty($_POST['Nsal_rep'])){$reposo=0;}else{$reposo=$_POST['Nsal_rep'];}
          if  (empty($_POST['Nsal_neto'])){$sueldoNeto=0;}else{$sueldoNeto=$_POST['Nsal_neto'];}
          //estos son los montos de tipo descuento
          if  (empty($_POST['Ntipo_des1'])){$MontoDescuento1=0;}else{$MontoDescuento1=$_POST['Ntipo_des1'];}
          if  (empty($_POST['Ntipo_des2'])){$MontoDescuento2=0;}else{$MontoDescuento2=$_POST['Ntipo_des2'];}
          if  (empty($_POST['Ntipo_des3'])){$MontoDescuento3=0;}else{$MontoDescuento3=$_POST['Ntipo_des3'];}
          if  (empty($_POST['Ntipo_des4'])){$MontoDescuento4=0;}else{$MontoDescuento4=$_POST['Ntipo_des4'];}
          //aqui necesito los codigos de los tipos descuentos
          if  (empty($_POST['Ncod_des1'])){$CodDescuento1=0;}else{$CodDescuento1=$_POST['Ncod_des1'];}
          if  (empty($_POST['Ncod_des2'])){$CodDescuento2=0;}else{$CodDescuento2=$_POST['Ncod_des2'];}
          if  (empty($_POST['Ncod_des3'])){$CodDescuento3=0;}else{$CodDescuento3=$_POST['Ncod_des3'];}
          if  (empty($_POST['Ncod_des4'])){$CodDescuento4=0;}else{$CodDescuento4=$_POST['Ncod_des4'];}
          
           $database = 'salario';
            
            
            //invoca al php en donde estan contenidas las funciones
           // include '../conexion.php';
            include '../funciones.php';
            $var= $_GET['nuevo'];
            echo $var;
             // si el registro es la pantalla nuevo
           if ($var==1 and $codFuncionario<>0){
                 if(func_SalarioDuplicado($codFuncionario, $database)){
                     
                     echo '<script type="text/javascript">
			alert("El Sueldo del Funcionario ya ha sido generado..!");
			 window.location="http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php";
			 </script>';
                       
                      }else{
                              $IPS=round($IPS);
                              $Ausencia=round($Ausencia);
                              $salarioPyT=round($salarioPyT20)+round($salarioPyT40)+round($salarioPyT50);
                              $ASO=round($ASO);
                              $Judicial=round($Judicial);
                              $reposo=round($reposo);
                              $sueldoNeto=round($sueldoNeto);
                              
                                //se define el Query   
                                $query = "INSERT INTO salario(usu_cod,fun_cod,sal_fecha,sal_ips,sal_aus,sal_pyt,sal_jud,sal_aso,sal_rep,sal_neto,sal_pyt20,sal_pyt40,sal_pyt50) 
                                VALUES (1,$codFuncionario,'now()',$IPS,$Ausencia,$salarioPyT,$Judicial,$ASO,$reposo,$sueldoNeto,$salarioPyT20,$salarioPyT40,$salarioPyT50);";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                                $query = '';
                                $var=0;

                                //ahora debemos cargar la parte de tipo descuentos..
                                if ($MontoDescuento1 > 0)
                                {
                                $query = '';     
                                $query = "INSERT INTO descuento(sal_cod,tde_cod,ode_mon) 
                                VALUES ((Select max(sal_cod) from salario),$CodDescuento1,$MontoDescuento1);";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                                }
                                 if ($MontoDescuento2 > 0)
                                {
                               $query = '';
                               $query = "INSERT INTO descuento(sal_cod,tde_cod,ode_mon) 
                                VALUES ((Select max(sal_cod) from salario),$CodDescuento2,$MontoDescuento2);";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga');   
                                }
                                 if ($MontoDescuento3 > 0)
                                {
                                $query = '';
                                $query = "INSERT INTO descuento(sal_cod,tde_cod,ode_mon) 
                                VALUES ((Select max(sal_cod) from salario),$CodDescuento3,$MontoDescuento3);";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga'); 
                                }
                                 if ($MontoDescuento4 > 0)
                                {
                               $query = '';
                               $query = "INSERT INTO descuento(sal_cod,tde_cod,ode_mon) 
                                VALUES ((Select max(sal_cod) from salario),$CodDescuento4,$MontoDescuento4);";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga'); 
                                }
                            header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");
                            }
         }
           //si el  registro es modificar ASO.
        elseif ($var==2){
                conexionlocal();
                $query ='';
                $ASO=round($ASO);
                $sueldoNeto=round($sueldoNeto);
                //se define el Query   
                $query = "update salario set usu_cod=1
                ,fun_cod=$codFuncionario
                ,sal_fecha='now()'
                ,sal_aso=$ASO
                ,sal_neto=$sueldoNeto
                where sal_cod=$codSalario;";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                $var=0;
                //redirigir
                 header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php"); 
        }
                 //si el  registro es modificar IPS.
        elseif ($var==3){
                conexionlocal();
                $query ='';
                $IPS=round($IPS);
                $sueldoNeto=round($sueldoNeto);
                //se define el Query   
                $query = "update salario set usu_cod=1
                ,fun_cod=$codFuncionario
                ,sal_fecha='now()'
                ,sal_ips=$IPS
                ,sal_neto=$sueldoNeto
                where sal_cod=$codSalario;";
                                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                $var=0;
                //redirigir
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");
        }
        //si el  registro es modificar descuendo Judicial.
        elseif ($var==4){
                conexionlocal();
                $query ='';
               $Judicial=round($Judicial);
                $sueldoNeto=round($sueldoNeto);
                //se define el Query   
                $query = "update salario set usu_cod=1
                ,fun_cod=$codFuncionario
                ,sal_fecha='now()'
                ,sal_jud=$Judicial
                ,sal_neto=$sueldoNeto
                where sal_cod=$codSalario;";
                                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                $var=0;
                //redirigir
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");
        }
        elseif ($var==5){
                conexionlocal();
                $query ='';
                $reposo=round($reposo);
                $sueldoNeto=round($sueldoNeto);
                //se define el Query   
                $query = "update salario set usu_cod=1
                ,fun_cod=$codFuncionario
                ,sal_fecha='now()'
                ,sal_rep=$reposo
                ,sal_neto=$sueldoNeto
                where sal_cod=$codSalario;";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                $var=0;
                //redirigir
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");
        }
        elseif ($var==6){
                conexionlocal();
                $query ='';
                $Ausencia=round($Ausencia);
                $IPS=round($IPS);
                $sueldoNeto=round($sueldoNeto);
                //se define el Query   
                $query = "update salario set usu_cod=1
                ,fun_cod=$codFuncionario
                ,sal_fecha='now()'
                ,sal_ips=$IPS
                ,sal_aus=$Ausencia
                ,sal_neto=$sueldoNeto
                where sal_cod=$codSalario;";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                $var=0;
                //redirigir
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");
        }
        elseif ($var==7){
                conexionlocal();
                $query ='';
                $salarioPyT=round($salarioPyT20)+round($salarioPyT40)+round($salarioPyT50);
                $sueldoNeto=round($sueldoNeto);
                //se define el Query   
                $query = "update salario set usu_cod=1
                ,fun_cod=$codFuncionario
                ,sal_fecha='now()'
                ,sal_pyt=$salarioPyT
                ,sal_pyt20=$salarioPyT20
                ,sal_pyt40=$salarioPyT40
                ,sal_pyt50=$salarioPyT50
                ,sal_neto=$sueldoNeto
                where sal_cod=$codSalario;";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                $var=0;
                //redirigir
                header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");
        }
//*********************************************************************************************************************
//esto ya es parte de tipo descuento
                                //ahora debemos cargar la parte de tipo descuentos..
                                if ($MontoDescuento1 > 0)
                                {
                                $query = '';     
                                $query = "update descuento set ode_mon=$MontoDescuento1 where sal_cod=$codSalario and tde_cod=$CodDescuento1;";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                                }
                                 if ($MontoDescuento2 > 0)
                                {
                               $query = '';
                               $query = "update descuento set ode_mon=$MontoDescuento2 where sal_cod=$codSalario and tde_cod=$CodDescuento2;";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga');   
                                }
                                 if ($MontoDescuento3 > 0)
                                {
                                $query = '';
                                $query = "update descuento set ode_mon=$MontoDescuento3 where sal_cod=$codSalario and tde_cod=$CodDescuento3;";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga'); 
                                }
                                 if ($MontoDescuento4 > 0)
                                {
                               $query = '';
                                $query = "update descuento set ode_mon=$MontoDescuento4 where sal_cod=$codSalario and tde_cod=$CodDescuento4;";
                                //ejecucion del query
                                $ejecucion = pg_query($query)or die('Error al realizar la carga'); 
                                }
         //  header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/FrmConsultaSueldo.php");                 
            
            else{ 
             header("Refresh:0; url=http://192.168.0.99/web/phpsueldos2015/userloget/principal.php");
             
             }
       
        ?>
    </body>
</html>
