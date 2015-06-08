/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

         function Refrescar(){
           location.reload();
        }
        //para agregar una linea en mi tabla
        function addLine() {
         //obtener el valor simple de un select
         var dia= document.getElementById('dias').value;
         //obtengo la posicion de un select de consulta
         var posicion=document.getElementById('descuento').options.selectedIndex;
         //de la posicion referida obtengo el valor del indice
         var descuento=document.getElementById('descuento').options[posicion].text; 
        //obtener el codigo del tipo descuento
        var codigoDescuento=document.getElementById('descuento').options[posicion].value;
        //obtengo valor del input monto
        var mon=document.getElementById('montos').value;
       
         if (descuento=='')
             {
             //  no hace nada alert('Debe ingresar un tipo de Descuento');
          }
          else{
             var tbl = document.getElementById('fastCartTable');
             var lastRow = tbl.rows.length;
             var row = tbl.insertRow(lastRow);
             var item = row.insertCell(0);
             var codigo = row.insertCell(1);
             var descripcion = row.insertCell(2);
             var monto=row.insertCell(3);
            
             item.innerHTML =lastRow;
             codigo.innerHTML =codigoDescuento;
             descripcion.innerHTML = descuento;
             if (dia!= 0)
                 {
                  monto.innerHTML=mon*dia;
                
                 }else{
                    monto.innerHTML=mon;
                  
                 }
            
           
             return false;
             }  
        
        }//fin de la funcion

        //para borrar un registro de mi tabla
        function deleteRow() {
        var indice;
        indice=prompt("Ingrese el Indice que desea Borrar");
         var table = document.getElementById('fastCartTable')
         if (indice > 0){
              table.deleteRow(indice);
         }else{
             alert("Ingrese un indice correcto");
         }
        
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
         var SaldoBruto= document.getElementById('sueldoNeto').value;
         var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
         document.getElementById("sueldoNeto").value=SaldoBrutoIni + (SaldoBruto*9)/100; 
         //guardamos el valor de salario neto(esto se actualizara con cada descuento)
         var sueldoneto=document.getElementById('sueldoNeto').value;
         document.getElementById("sal_neto").value=sueldoneto;
         document.getElementById("sal_ips").value=0; 
         
        }
        function DescontarIPS(){
         var SaldoBruto= document.getElementById('sueldoNeto').value;
         var SaldoBrutoIni=document.getElementById('sueldoBruto').value;
         document.getElementById("sueldoNeto").value=SaldoBrutoIni - (SaldoBruto*9)/100; 
         document.getElementById("sal_ips").value=(SaldoBruto*9)/100; 
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
            //reestablece los valores al cambiar dias
             if(sal_aus > 0)
                 {
                 var suma=parseFloat(SaldoNeto) + parseFloat(sal_aus);
                 document.getElementById("sueldoNeto").value=suma;
             
                }
                 var SueldoBrutoIni=document.getElementById('sueldoBruto').value;
                 //calcula el jpornal diario
                 var jornal=SueldoBrutoIni/30;
                 //obtiene la cantidad de dias
                 var dias=document.getElementById('DiaAusencia').value;
                 //calcula jornal diario por cantidad de dias
                 document.getElementById("sal_aus").value=jornal*dias;
                 //Actualiza el neto a cobrar
                 var SaldoNeto= document.getElementById('sueldoNeto').value;
                 document.getElementById("sueldoNeto").value=SaldoNeto-(jornal*dias);
                  //guardamos el valor de salario neto(esto se actualizara con cada descuento)
                var sueldoneto=document.getElementById('sueldoNeto').value;
                document.getElementById("sal_neto").value=sueldoneto;
             
            
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


