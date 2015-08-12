
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Salarios Fuente 10</title>
        <link href="../Site.css" rel="stylesheet">
        <link href="../tabla.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width" />
        <meta charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
		<link rel="stylesheet" href="twitter-signup.css" type="text/css" />
    </head>
    <body>
        <script>
         function Refrescar(){
           location.reload();
        }
        function ActualizaInput(){
            document.getElementById("cin").value = " ";
            document.getElementById("organismo").value = " ";
            document.getElementById("categoria").value = " ";  
        }
         function ActualizaInputDetalle(){
            document.getElementById("montos").value = " ";
         }
        
        //calcular DESCUENTOS IPS
       function DescuentosIPS(){
         var SaldoNeto= document.getElementById('sueldoNeto').value;
         var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
        
         document.getElementById("sueldoNeto").value=parseFloat(SaldoNeto) + ((SaldoBrutoIni*9)/100); 
         //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
        
         document.getElementById("sal_neto").value=sueldoneto;
         document.getElementById("sal_ips").value=0;
         //guarda en el input a mostrar el valor 0 (no se descuenta)
         document.getElementById("IPSMONTO").value=0;
         
        }
        function DescontarIPS(){
      
         var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
         document.getElementById("sueldoNeto").value=SaldoBrutoIni - (SaldoBrutoIni*9)/100; 
         document.getElementById("sal_ips").value=(SaldoBrutoIni*9)/100;
         //guarda el monto del IPS descontado en el Input IPS
         document.getElementById("IPSMONTO").value=parseFloat((SaldoBrutoIni*9)/100);
         //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
         
        }
        function noReadOnly(){
            var campo = document.getElementById('InputASO');
            campo.readOnly = false; // Se añade el atributo
        }
        //no read only Judicial
        
        function noReadOnlyJudicial(){
            var campo = document.getElementById('inputJudicial');
            campo.readOnly = false; // Se añade el atributo
        }
        //se calcula los descuentos por AUSENCIA
        function DescuentoAusencia(){
            //recupero el valor de ausencia
            var sal_aus= document.getElementById("sal_aus").value;
            var SaldoNeto= document.getElementById('sueldoNeto').value;
            var SueldoBrutoIni=document.getElementById('sueldoBruto').value;
            var IPSanterior=document.getElementById("sal_ips").value;
            var dias=document.getElementById('DiaAusencia').value;
            var jornal=SueldoBrutoIni/30;
            //reestablece los valores al cambiar dias
             if(sal_aus > 0)
              {
              var suma=parseFloat(SaldoNeto) + parseFloat(sal_aus);
              document.getElementById("sueldoNeto").value=suma;
              //reiniciamos el valor de IPS
              document.getElementById("sal_ips").value=(SueldoBrutoIni*9)/100;
              //despliega el IPS que debe mostrar
              document.getElementById("IPSMONTO").value=(SueldoBrutoIni*9)/100;
              }
               //reestablece sueldo Neto
              document.getElementById("sueldoNeto").value= parseFloat(SaldoNeto) + parseFloat(IPSanterior);
              var sueldoNetoRees=document.getElementById("sueldoNeto").value;
              //obtiene la cantidad de dias
              var dias=document.getElementById('DiaAusencia').value;
              //calcula jornal diario por cantidad de dias
              document.getElementById("sal_aus").value=jornal*dias;
              var descuento=document.getElementById("sal_aus").value;
              //una vez que haya calculado el descuento, calcula el nuevo IPS
              var SueldoDescuento=sueldoNetoRees-descuento;
              document.getElementById("sueldoNeto").value=SueldoDescuento;
              var nuevoIPS=(SueldoDescuento*9)/100;
              document.getElementById("sal_ips").value=nuevoIPS;
              document.getElementById("IPSMONTO").value=nuevoIPS;
              //se termino de calcular el nuevo IPS
             //ahora calculamos el nuevo sueldo neto restando el nuevo IPS
             var SN=document.getElementById("sueldoNeto").value;
             document.getElementById('sueldoNeto').value=parseFloat(SN)-parseFloat(nuevoIPS);
             //fin del algoritmo..
        }
        //se calcula el descuento por ASO
        function DescuentoASO(){
            //obtiene sal_aso
            var sal_aso=document.getElementById("sal_aso").value
             //valor del input de sueldo neto
            var SaldoNeto= document.getElementById('sueldoNeto').value;
            //si anteriormente ya tenia un valor restaura ante cambios del operador
             if(sal_aso > 0)
                 {
                 var suma=parseFloat(SaldoNeto) + parseFloat(sal_aso);
                 document.getElementById("sueldoNeto").value=suma;
                }
                //valor del input ASO
             var monto= document.getElementById('InputASO').value;
             //el nuevo valor de Saldo Neto
             var SaldoNeto= document.getElementById("sueldoNeto").value;
             document.getElementById("sueldoNeto").value=(SaldoNeto-monto);
             document.getElementById("sal_aso").value=monto;
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
          var sueldoneto=document.getElementById('sueldoNeto').value;
          document.getElementById("sal_neto").value=sueldoneto;
        }
        
       
        //se calcula el descuento judicial
        function  DescuentoJudicial(){     
             //obtiene el valor anterior de sal_jud
            var sal_jud=document.getElementById("sal_jud").value
             //valor del input de sueldo neto
            var SaldoNeto= document.getElementById('sueldoNeto').value;
            //si anteriormente ya tenia un valor restaura ante cambios del operador
             if(sal_jud > 0)
                 {
                 var suma=parseFloat(SaldoNeto) + parseFloat(sal_jud);
                 document.getElementById("sueldoNeto").value=suma;
                }
                //valor del input del descuento judicial
             var monto= document.getElementById('inputJudicial').value;
             //el nuevo valor de Saldo Neto
             var SaldoNeto= document.getElementById("sueldoNeto").value;
             document.getElementById("sueldoNeto").value=(SaldoNeto-monto);
             document.getElementById("sal_jud").value=monto;
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
            var sueldoneto=document.getElementById('sueldoNeto').value;
            document.getElementById("sal_neto").value=sueldoneto;
            
        }
        
        //descuento de 20 por Permiso o LLegada tardia
         function Descuento20(){
             //recuperamos el valor descuento20 anterior
             var descuento20=document.getElementById("sal_pyt20").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento20 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento20);
                 document.getElementById("sueldoNeto").value=suma;
                }
             //sueldo bruto inicial
             var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=SaldoBrutoIni/30;
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('descuento20').value;
             //descuento por dia de 20 %
             var descuento20=((jornal*20)/100)
             //obtener el valor actual del sal_pyt//esto se debe sumar al total de descuento  sal aso
             //de 20, 40 y 50 por ciento.
             document.getElementById("sal_pyt20").value=(descuento20*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuento20*dias);
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
        }
        //descuento de 40 por Permiso o LLegada tardia
        function Descuento40(){
             //recuperamos el valor descuento40 anterior
             var descuento40=document.getElementById("sal_pyt40").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento40 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento40);
                 document.getElementById("sueldoNeto").value=suma;
                }
             //sueldo bruto inicial
             var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=SaldoBrutoIni/30;
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('descuento40').value;
             //descuento por dia de 40 %
             var descuento40=((jornal*40)/100)
             //actualizar valor de sal_pyt
              document.getElementById("sal_pyt40").value=(descuento40*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuento40*dias);
             
             
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
        }
        
        //descuento de 50 por ciento por permiso o llegada tardia
        function Descuento50(){
             //recuperamos el valor descuento50 anterior
             var descuento50=document.getElementById("sal_pyt50").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento50 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento50);
                 document.getElementById("sueldoNeto").value=suma;
                }
             //sueldo bruto inicial
             var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=SaldoBrutoIni/30;
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('descuento50').value;
             //descuento por dia de 50 %
             var descuento50=((jornal*50)/100);
            
             //actualizar valor de sal_pyt
              document.getElementById("sal_pyt50").value=(descuento50*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuento50*dias);
             
             
             
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
        }
        
        //calculamos el descuento de reposo//50% descuenta INTN y 50% IPS
        //estos valores pueden variar en dias y horas..se paga mitad y mitad.
        function DescuentoReposo(){
            
             //recuperamos el valor descuento reposo anterior
             var descuentoReposo=document.getElementById("sal_rep").value;
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuentoReposo > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuentoReposo);
                 document.getElementById("sueldoNeto").value=suma;
                }
            
             var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
             //calcula el jpornal diario
             var jornal=SaldoBrutoIni/30;
             //obtiene dias de permisos/llegada tardia
             var dias= document.getElementById('DiaReposo').value;
             //descuento por dia de 50 %
             var descuentoINTN=(jornal/2);
             document.getElementById("sal_rep").value=(descuentoINTN*dias);
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-(descuentoINTN*dias);
             
             
             
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
        }
        
        //se calcula el tipo descuento 1
        function  TipoDescuento1(){
             //recuperamos el valor descuento 1 anterior
             var descuento1=document.getElementById("tipo_des1").value;
            
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento1 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento1);
                 document.getElementById("sueldoNeto").value=suma;
                }

            //el valor que se ingreso en monto
             var monto= document.getElementById('tipoDescuento1').value;
             document.getElementById("tipo_des1").value=monto;
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-monto;
             
             //codigo de descuento la cual guardaremos
             var posicion=document.getElementById('tipodescuento1').options.selectedIndex;
              var codigoDescuento1=document.getElementById('tipodescuento1').options[posicion].value;
               document.getElementById("cod_des1").value=codigoDescuento1;
              
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
            var sueldoneto=document.getElementById('sueldoNeto').value;
            document.getElementById("sal_neto").value=sueldoneto;
        }
        //se calcula el tipo descuento 2
        function  TipoDescuento2(){
              //recuperamos el valor descuento 2 anterior
             var descuento2=document.getElementById("tipo_des2").value;
            
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento2 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento2);
                 document.getElementById("sueldoNeto").value=suma;
                }
             var monto= document.getElementById('tipoDescuento2').value;
             document.getElementById("tipo_des2").value=monto;
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-monto;
             
             //codigo de descuento la cual guardaremos
             var posicion=document.getElementById('tipodescuento2').options.selectedIndex;
              var codigoDescuento2=document.getElementById('tipodescuento2').options[posicion].value;
              document.getElementById("cod_des2").value=codigoDescuento2;
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
            var sueldoneto=document.getElementById('sueldoNeto').value;
            document.getElementById("sal_neto").value=sueldoneto;
        }
        //se calcula el tipo descuento 3
        function  TipoDescuento3(){
             //recuperamos el valor descuento 3 anterior
             var descuento3=document.getElementById("tipo_des3").value;
         
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento3 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento3);
                 document.getElementById("sueldoNeto").value=suma;
                }
                
             var monto= document.getElementById('tipoDescuento3').value;
             document.getElementById("tipo_des3").value=monto;
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-monto;
             
             //codigo de descuento la cual guardaremos
             var posicion=document.getElementById('tipodescuento3').options.selectedIndex;
              var codigoDescuento3=document.getElementById('tipodescuento3').options[posicion].value;
              document.getElementById("cod_des3").value=codigoDescuento3;
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
            var sueldoneto=document.getElementById('sueldoNeto').value;
            document.getElementById("sal_neto").value=sueldoneto;
        }
        //se calcula el tipo descuento 4
        function  TipoDescuento4(){
              //recuperamos el valor descuento 4 anterior
             var descuento4=document.getElementById("tipo_des4").value;
             
             //recuperamos el sueldo neto del input
             var SueldoNeto=document.getElementById('sueldoNeto').value;
             //si anteriormente ya tenia un valor, debe reestablecer
             if(descuento4 > 0)
                 {
                 var suma=parseFloat(SueldoNeto) + parseFloat(descuento4);
                 document.getElementById("sueldoNeto").value=suma;
                }
                
             var monto= document.getElementById('tipoDescuento4').value;
             document.getElementById("tipo_des4").value=monto;
             //Actualiza el neto a cobrar
             var SaldoNeto= document.getElementById('sueldoNeto').value;
             document.getElementById("sueldoNeto").value=SaldoNeto-monto;
             
             //codigo de descuento la cual guardaremos
             var posicion=document.getElementById('tipodescuento4').options.selectedIndex;
              var codigoDescuento4=document.getElementById('tipodescuento4').options[posicion].value;
              document.getElementById("cod_des4").value=codigoDescuento4;
             //guardamos el valor de salario neto(esto se actualizara con cada descuento)
            var sueldoneto=document.getElementById('sueldoNeto').value;
            document.getElementById("sal_neto").value=sueldoneto;
        }
         function noReadOnlyDescuento1(){
            var campo = document.getElementById('tipoDescuento1');
            campo.readOnly = false; // Se añade el atributo
        }
         function noReadOnlyDescuento2(){
            var campo = document.getElementById('tipoDescuento2');
            campo.readOnly = false; // Se añade el atributo
        }
         function noReadOnlyDescuento3(){
            var campo = document.getElementById('tipoDescuento3');
            campo.readOnly = false; // Se añade el atributo
        }
         function noReadOnlyDescuento4(){
            var campo = document.getElementById('tipoDescuento4');
            campo.readOnly = false; // Se añade el atributo
        }
         function ReadOnlyDescuento1(){
            var campo = document.getElementById('tipoDescuento1');
            campo.readOnly = true; // Se añade el atributo
        }
         function ReadOnlyDescuento2(){
            var campo = document.getElementById('tipoDescuento2');
            campo.readOnly = true; // Se añade el atributo
        }
         function ReadOnlyDescuento3(){
            var campo = document.getElementById('tipoDescuento3');
            campo.readOnly = true; // Se añade el atributo
        }
         function ReadOnlyDescuento4(){
            var campo = document.getElementById('tipoDescuento4');
            campo.readOnly = true; // Se añade el atributo
        }
</script>
               <div class='clearfix'></div>
               <a href="http://localhost/app/phpsueldos/userloget/principal.php"><strong><H3>Volver al Menu Principal</H3></strong></a> <br>
                    <div id="twitter">
                    
                      <FORM action="FrmSalarioF10.php" method="post">
			<div id='name' class='outerDiv'>   
                            <label for="txtFuncionario">Funcionario:</label> 
                            <select name="txtFuncionario"  onchange="ActualizaInput()" >
                                    <option selected >
                                    <?php
                                    include './funciones.php';
                                    conexionlocal();
                                    $query = "Select FUN.fun_cod,concat(FUN.fun_nom,' ',FUN.fun_ape) as fun_nom from funcionario FUN, categoria_detalle CATDET, organismo_detalle ORGDET 
                                    where FUN.fun_fuente='10' 
                                    and FUN.fun_cod=CATDET.fun_cod
                                    and FUN.fun_cod=ORGDET.fun_cod 
                                    order by fun_nom";
                                    $resultadoSelect = pg_query($query);
                                    while ($row = pg_fetch_row($resultadoSelect)) {
                                    echo "<option value=".$row[0]."> ";
                                    echo $row[1];   
                                    echo "</option>";
                                    }
                                    ?>
                            </select>
                             <div class='clearfix'></div>
                            <div id='name' class='outerDiv'>    
                            <label for="txtCI">CI Nº</label> 
                            <input type="text" name="txtCIConfirm"  id="cinConfirm" maxlength="9"   /> 
                            </div>
                            <?php 
                             //aqui comienza nuestra funcion cuando se recupera datos del funcionario
                             if  (empty($_POST['txtCIConfirm'])){$codigoFun=0;}else
                                 {
                                 $codigoFun=$_POST['txtCIConfirm'];
                                 $query2 = "select FUNC.fun_cod as CODIGOFUNCIONARIO,
                                     FUNC.fun_nom as NOMBRE,FUNC.fun_ape as APELLIDO,
                                     FUNC.fun_ci as CI,ORG.org_des as ORGANISMO,
                                     CAT.cat_des as CATEGORIA,CAT.cat_nom as MONTOCATEGORIA
                                    from funcionario FUNC, categoria CAT, 
                                    organismo ORG,organismo_detalle ORGDET,categoria_detalle CATDET 
                                    where FUNC.fun_cod=ORGDET.fun_cod
                                    and ORGDET.org_cod=ORG.org_cod
                                    and FUNC.fun_cod=CATDET.fun_cod
                                    and CATDET.cat_cod=CAT.cat_cod
                                    and FUNC.fun_ci=".$codigoFun;
                                    $resultadoSelect2 = pg_query($query2);
                                    $row2 = pg_fetch_row($resultadoSelect2);  
                                 }
                                 //aqui comienza nuestra funcion cuando se recupera datos del funcionario
                             if  (empty($_POST['txtFuncionario'])){$codigoFun=0;}else
                                 {
                                 $codigoFun=$_POST['txtFuncionario'];
                                 $query2 = "select FUNC.fun_cod as CODIGOFUNCIONARIO,
                                     FUNC.fun_nom as NOMBRE,FUNC.fun_ape as APELLIDO,
                                     FUNC.fun_ci as CI,ORG.org_des as ORGANISMO,
                                     CAT.cat_des as CATEGORIA,CAT.cat_nom as MONTOCATEGORIA
                                    from funcionario FUNC, categoria CAT, 
                                    organismo ORG,organismo_detalle ORGDET,categoria_detalle CATDET 
                                    where FUNC.fun_cod=ORGDET.fun_cod
                                    and ORGDET.org_cod=ORG.org_cod
                                    and FUNC.fun_cod=CATDET.fun_cod
                                    and CATDET.cat_cod=CAT.cat_cod
                                    and FUNC.fun_cod=".$codigoFun;
                                    $resultadoSelect2 = pg_query($query2);
                                    $row2 = pg_fetch_row($resultadoSelect2);  
                                 }   
                            ?>
                    </div>               
                    <div class='clearfix'></div>
                    <div align="center" id='submit' class='outerDiv'>
                    <input  type="submit" name="submit" value="Confirmar"/>
                     <div class='clearfix'></div>
                    </div>
                    </FORM>
                <div class='clearfix'></div>
                    <div id='name' class='outerDiv'>    
                    <label for="txtNombre">Nombre:</label> 
                    <input type="text" style="background-color:#EfEfEf " name="txtNombre" id="cin" readonly="true" value="<?php if(empty ($row2[1])){$value=0;}else{$value=$row2[1].' '.$row2[2];echo$value;}?>" required  /> 
                    </div>
                        <div class='clearfix'></div>
                    <div id='name' class='outerDiv'>    
                    <label for="txtCI">CI Nº</label> 
                    <input type="text" name="txtCI" style="background-color:#EfEfEf " id="cin" maxlength="9" readonly="true" value="<?php if(empty ($row2[3])){$value=0;}else{$value=$row2[3];echo$value;}?>" required  /> 
                    </div>
                <div class='clearfix'></div> 
                    <div id='name' class='outerDiv'>
                    <label for="txtOrganismo">Organismo</label> 
                    <input type="text" name="txtOrganismo" style="background-color:#EfEfEf " id="organismo" readonly="true" value="<?php if(empty ($row2[4])){$value=0;}else{$value=$row2[4];echo$value;}?>"  required  /> 
                    </div>
                    <div class='clearfix'></div> 
                    <div id='name' class='outerDiv'>
                    <label for="txtCategoria">Categoria </label> 
                    <input type="text" name="txtCategoria" style="background-color:#EfEfEf " id="categoria" readonly="true"  value="<?php if(empty ($row2[5])){$value=0;}else{$value=$row2[5];echo$value;}?>" required  /> 
                    </div>
                  <div class='clearfix'></div> 
                    <div id='name' class='outerDiv'>
                    <label for="txtSueldo">Sueldo Bruto:</label> 
                    <input type="number" name="txtSueldo" style="background-color:#EfEfEf " id="sueldoBruto" readonly="true"  value="<?php if(empty ($row2[6])){$value=0;}else{$value=$row2[6];echo$value;}?>" required  /> 
                    </div>
                  <div class='clearfix'></div> 
                    <div id='name' class='outerDiv'>
                    <label for="txtSueldoNeto">Sueldo Neto:</label> 
                    <input type="number" name="txtSueldoNeto" step="0" style="background-color:#ff0 " id="sueldoNeto" readonly="true"  value="<?php if(empty ($row2[6])){$value=0;}else{$value=$row2[6];echo $value - (($value * 9)/100);}?>" required  /> 
                    </div>
                    <div class='clearfix'></div>
                    </br></br>
                  <table>
                      <caption>Ausencias, Permisos y Llegadas Tardías </caption>  
                         <th>Ausencias </th><th> 20% </th><th> 40% </th><th> 50% </th>   
                        <tr>
                             <td>
                            <input type=radio  name="ausen" value=1>Descontar <br>
                            <input type=radio  name="ausen" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='Ausencia' onchange='DescuentoAusencia()' id='DiaAusencia'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </td>
                            <td>
                            <fieldset>
                            <legend align= "left">20%</legend>
                            <input type=radio name="ausen20" value=1>Descontar <br>
                            <input type=radio name="ausen20" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='dia' id='descuento20' onchange='Descuento20()'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                        <td>
                            <fieldset>
                            <legend align= "left">40%</legend>
                            <input type=radio name="ausen40" value=1>Descontar <br>
                            <input type=radio name="ausen40" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='dia' id='descuento40' onchange='Descuento40()'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                            <td>
                            <fieldset>
                            <legend align= "left">50%</legend>
                            <input type=radio name="ausen50" value=1>Descontar <br>
                            <input type=radio name="ausen50" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='dia' id='descuento50' onchange='Descuento50()'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                             
                            </tr>
            </table>
              <table>
                 <caption>Descuentos Varios</caption>  
                 <th> IPS </th><th> Reposo </th><th> Asociación INTN </th><th> Judiciales </th>
                        <tr>
                        <td>
                        <fieldset>
                        <legend align= "left">IPS  </legend>
                        <input type=radio name="ips"  value=1  onclick="DescontarIPS()" checked>Descontar <br>
                        <input type=radio name="ips" onclick="DescuentosIPS()" value=0 >No descontar
                       <INPUT type="numeric"  id="IPSMONTO" name="txtIPSMonto" readonly="true" value="<?php if(empty ($row2[6])){$value=0;}else{$value=$row2[6];echo (($value * 9)/100);}?>"><BR>
                        </fieldset>
                        </td>
                        <td>
                            <fieldset>
                            <legend align= "left">Reposo</legend>
                            <input type=radio  name="reposo" value=1>Descontar <br>
                            <input type=radio  name="reposo" onclick="Refrescar()" value=0 checked>No descontar<br>
                           <?php
                            echo "<select name='Reposo' onchange='DescuentoReposo()' id='DiaReposo'>";
                                for($i=0;$i<=31;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            echo "</select>";
                            ?>
                            </fieldset>
                            </td>
                            <td>
                            <fieldset>
                            <legend align= "left">Asociación INTN</legend>
                            <input type=radio name="aso" onclick="noReadOnly()" value=1>Descontar  <br>
                            <input type=radio name="aso" value=0 onclick="Refrescar()" checked>No descontar<br>
                            Monto:<INPUT type="numeric" onchange="DescuentoASO()" id="InputASO" name="montoaso" value="0" "onKeypress="if ((event.keyCode < 45 || event.keyCode > 57) && (event.keyCode != 13)) event.returnValue = false;" readonly="true"><BR>
                            </fieldset>
                            </td>
                            <td>
                            <fieldset>
                            <legend align= "left">Descuentos Judiciales</legend>
                            <input type=radio name="judicial" onclick="noReadOnlyJudicial()" value=1>Descontar  <br>
                            <input type=radio name="judicial" value=0 onclick="Refrescar()" checked>No descontar<br>
                            Monto:<INPUT type="numeric" onchange=" DescuentoJudicial()" id="inputJudicial" value="0" name="txtDescuentoJudicial" onKeypress="if ((event.keyCode < 45 || event.keyCode > 57)  && (event.keyCode != 13)) event.returnValue = false;" readonly="true"><BR>
                            </fieldset>
                            </td>
                            </tr>
                         </table>
            <div id='name' class='outerDiv'>
                    <div class='clearfix'></div>
                    <h3>Agregar Descuentos a Salario</h3>
                    <div class='clearfix'></div>
                   <table>
                      <caption>Otros Descuentos (Tipos Descuentos) </caption>  
                         <th>Tipo Descuento 1 </th><th> Tipo Descuento 2 </th><th> Tipo Descuento 3 </th><th> Tipo Descuento 4 </th>   
                        <tr>
                             <td>
                            <input type=radio  name="tipodescuento1" onclick="noReadOnlyDescuento1()" value=1>Descontar <br>
                            <input type=radio  name="tipodescuento1" onclick="ReadOnlyDescuento1()" value=0 checked>No descontar<br>
                          
                            <select name="txtTipodescuento1"  id="tipodescuento1" required>
                                    <option selected >
                                    <?php
                                    $query = "Select tde_cod,tde_des from tipo_descuento ";
                                    $resultadoSelect = pg_query($query);
                                    while ($row = pg_fetch_row($resultadoSelect)) {
                                    echo "<option value=".$row[0]."> ";
                                    echo $row[1];   
                                    echo "</option>";
                                    }
                                    ?>
                            </select>
                             Monto:<INPUT type="numeric" onchange="TipoDescuento1()" id="tipoDescuento1" onKeypress="if ((event.keyCode < 45 || event.keyCode > 57) && (event.keyCode != 13)) event.returnValue = false;" name="txttipoDescuento1" readonly="true"><BR>
                            </td>
                            <td>
                            <input type=radio  name="tipodescuento2" onclick="noReadOnlyDescuento2()" value=1>Descontar <br>
                            <input type=radio  name="tipodescuento2" onclick="ReadOnlyDescuento2()" value=0 checked>No descontar<br>
                          
                            <select name="txtTipodescuento2"  id="tipodescuento2" required>
                                    <option selected >
                                    <?php
                                    $query = "Select tde_cod,tde_des from tipo_descuento ";
                                    $resultadoSelect = pg_query($query);
                                    while ($row = pg_fetch_row($resultadoSelect)) {
                                    echo "<option value=".$row[0]."> ";
                                    echo $row[1];   
                                    echo "</option>";
                                    }
                                    ?>
                            </select>
                              Monto:<INPUT type="numeric" onchange="TipoDescuento2()" id="tipoDescuento2" onKeypress="if ((event.keyCode < 45 || event.keyCode > 57) && (event.keyCode != 13)) event.returnValue = false;" name="txttipoDescuento2" readonly="true"><BR>
                            </td>
                        <td>
                            <input type=radio  name="tipodescuento3" onclick="noReadOnlyDescuento3()"value=1>Descontar <br>
                            <input type=radio  name="tipodescuento3" onclick="ReadOnlyDescuento3()" value=0 checked>No descontar<br>
                          
                            <select  name="txtTipodescuento3" id="tipodescuento3"  required>
                                    <option selected >
                                    <?php
                                    $query = "Select tde_cod,tde_des from tipo_descuento ";
                                    $resultadoSelect = pg_query($query);
                                    while ($row = pg_fetch_row($resultadoSelect)) {
                                    echo "<option value=".$row[0]."> ";
                                    echo $row[1];   
                                    echo "</option>";
                                    }
                                    ?>
                            </select>
                              Monto:<INPUT type="numeric" onchange="TipoDescuento3()"onKeypress="if ((event.keyCode < 45 || event.keyCode > 57) && (event.keyCode != 13)) event.returnValue = false;" id="tipoDescuento3" name="txttipoDescuento3" readonly="true"><BR>
                            </td>
                            <td>
                            <input type=radio  name="tipodescuento4" onclick="noReadOnlyDescuento4()" value=1>Descontar <br>
                            <input type=radio  name="tipodescuento4" onclick="ReadOnlyDescuento4()" value=0 checked>No descontar<br>
                          
                            <select name="txtTipodescuento4" id="tipodescuento4"  required>
                                    <option selected >
                                    <?php
                                    $query = "Select tde_cod,tde_des from tipo_descuento ";
                                    $resultadoSelect = pg_query($query);
                                    while ($row = pg_fetch_row($resultadoSelect)) {
                                    echo "<option value=".$row[0]."> ";
                                    echo $row[1];   
                                    echo "</option>";
                                    }
                                    ?>
                            </select>
                              Monto:<INPUT type="numeric" onchange="TipoDescuento4()" id="tipoDescuento4" onKeypress="if ((event.keyCode < 45 || event.keyCode > 57)  && (event.keyCode != 13)) event.returnValue = false;" name="txttipoDescuento4" readonly="true"><BR>
                            </td>
                            </tr>
                </table>
            </div>
                    <form action="clases/ClsSalario.php?nuevo=1" method="post" onClik="submit" >
                    <input type="hidden" name="Nfun_cod" value="<?php if(empty ($row2[0])){$value=0;}else{$value=$row2[0];echo$value;}?>"/> 
                    <input type="hidden" id="sal_pyt20" name="Nsal_pyt20" >
                    <input type="hidden" id="sal_pyt40" name="Nsal_pyt40" >
                    <input type="hidden" id="sal_pyt50" name="Nsal_pyt50">
                    <input type="hidden" id="sal_aso" name="Nsal_aso" >
                    <input type="hidden" id="sal_jud" name="Nsal_jud" >
                    <input type="hidden" id="sal_aus" name="Nsal_aus" >
                    <input type="hidden" id="sal_ips" name="Nsal_ips" value="<?php if(empty ($row2[6])){$value=0;}else{$value=$row2[6];echo (($value * 9)/100);}?>"/> 
                    <input type="hidden" id="sal_rep" name="Nsal_rep" >
                    <input type="hidden" id="sal_neto" name="Nsal_neto" value="<?php if(empty ($row2[6])){$value=0;}else{$value=$row2[6];echo $value - (($value * 9)/100);}?>" >
                    <input type="hidden" id="tipo_des1" name="Ntipo_des1" >
                    <input type="hidden" id="tipo_des2" name="Ntipo_des2" >
                    <input type="hidden" id="tipo_des3" name="Ntipo_des3" >
                    <input type="hidden" id="tipo_des4" name="Ntipo_des4" >
                     <input type="hidden" id="cod_des1" name="Ncod_des1" >
                     <input type="hidden" id="cod_des2" name="Ncod_des2" >
                     <input type="hidden" id="cod_des3" name="Ncod_des3" >
                     <input type="hidden" id="cod_des4" name="Ncod_des4" >
                    <div align="center" id='submit' class='outerDiv'>
                    <input type="submit" name="submit" value="Guardar" onclik="" />
                    <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://localhost/app/phpsueldos/userloget/principal.php'"/>  
                    <div class='clearfix'></div>
                    </div>
                    </form>
    </div>
 <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
 </body>
<script type="text/javascript">
            
            function Cancelar(){
            location.href("http://localhost/app/phpsueldos/principal.php")
    }
</script>
</html>
