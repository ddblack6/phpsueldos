
<!DOCTYPE html>
<html>
    <!--
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */
-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Categoria Detalles</title>
        <link href="../Site.css" rel="stylesheet">
        
        <meta name="viewport" content="width=device-width" />
        <!//<meta http-equiv="X-UA-Compatible" content="chrome=1" /><!-- Optimistically rendering in Chrome Frame in IE. --> 
        <link rel="stylesheet" href="twitter-signup.css" type="text/css" />
         <link href="../tabla.css" rel="stylesheet">
        <script type="text/javascript">
            var variablejs;
        function Modificar(codigo) {
           
           //paso este dato a mi php
                document.cookie ='var='+codigo; 
                document.cookie =0;
    }
        function Refrescar(){
            
           location.reload()
        }
        function Cancelar(){
             
            location.href("http://192.168.0.99/web/phpsueldos/principal.php")
        }
        function checkEstado(form){
              if (form.checksituacion=='t')
                {
                form.checksituacion.checked = true;
                }
                if (form.checkjubilado=='t')
                {
                form.checksituacion.checked = true;
                }
         }  
    </script>
<?php
 if  (empty($_COOKIE["var"])){
     $codigo=0;    
 }  else
 {
     $codigo = $_COOKIE["var"];
     setcookie("var", $_COOKIE["var"], time()+12);
 }

//recibo el codigo y hago el query
include './funciones.php';
 conexionlocal();
$result = pg_query("SELECT FUNC.fun_cod,CAT.cat_des,FUNC.fun_ci,FUNC.fun_nom,FUNC.fun_ape,to_char(CATDET.cad_fec,'DD/MM/YYYY')  as cad_fec FROM funcionario FUNC, categoria_detalle CATDET,categoria CAT  where FUNC.fun_cod=CATDET.fun_cod and FUNC.fun_cod= ".$codigo); 
$row = pg_fetch_array($result);

?>
    </head>
    <body>
        <?php include("principal.php");?>
        <div id="twitter">
     
        <div class='clearfix'></div>
        

                    <div id="twitter">
                        <form autocomplete="off" action="clases/ClsCategoriaDetalle.php?nuevo=2" method="post" onClik="submit"> 
                                                        <div id='name' class='outerDiv'>
							<input type="hidden" name="txtcodigo" value="<?php echo $row['fun_cod'];?>" required  /> 
							<div class='message' id='nameDiv'></div>
                                                         </div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtCategoria">Categoría:</label> 
                                                        <select name="txtCategoria" required>
                                                            <option selected>
                                                            <?php
                                                            $query1 = "Select cat_cod ,cat_des from categoria";
                                                            $resultadoSelect = pg_query($query1);
                                                            while ($row2 = pg_fetch_row($resultadoSelect)) {
                                                            echo "<option value=".$row2[0].">";
                                                            echo $row2[1];
                                                            echo "</option>";
                                                              }


                                                             ?>
                                                          </select>
                                                         </div>
                                                        <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
                                                        <label for="txtFuncionario">Funcionario:</label> 
                                                        <select name="txtFuncionario" required>
                                                            <option selected>
                                                            <?php
                                                            $query1 = "Select fun_cod,concat(fun_nom,' ',fun_ape) as fun_nom from funcionario order by fun_nom";
                                                            $resultadoSelect = pg_query($query1);
                                                            while ($row1 = pg_fetch_row($resultadoSelect)) {
                                                            echo "<option value=".$row1[0].">";
                                                            echo $row1[1];
                                                            echo "</option>";
                                                              }


                                                             ?>
                                                          </select>
                                                         </div>
                                                        <div class='clearfix'></div>
                                                        <div id='name' class='outerDiv'>
							<label for="txtFecha">Fecha:</label> 
							<input type="date" name="txtFecha" value="<?php echo $row['cad_fec'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese número de CI </div>
                                                        </div>
                                                        <div class='clearfix'></div>
						<div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                                <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://192.168.0.99/web/phpsueldos/userloget/principal.php'"/>  
                                                </div>
                                                <div class='clearfix'></div>
                            </form>       
                          <div class='clearfix'></div>
                            </div>
        <div class='clearfix'></div>
        <div class="centerTable" >
             <?php 
                  
                  // include './funciones.php';
                   //hace una conexion local
                     // conexionlocal();
                     $result = pg_query("SELECT row_number()over (partition by 0 order by FUNC.fun_cod) as   lineas,FUNC.fun_cod,CAT.cat_des,CAT.cat_nom,FUNC.fun_ci,FUNC.fun_nom,FUNC.fun_ape,to_char(CATDET.cad_fec,'DD/MM/YYYY')  as cad_fec FROM funcionario FUNC, categoria_detalle CATDET,categoria CAT  where FUNC.fun_cod=CATDET.fun_cod and CATDET.cat_cod=CAT.cat_cod order by FUN_COD"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                        echo " <caption>Modificar Detalles Categorías (Presione Ctrl+F para buscar)</caption>";
                       echo "<th>Línea</th><th>Código Funcionario</th><th>Categoría</th><th>Monto</th><th>C.I. Nº</th><th>Nombre</th><th>Apellido</th><th>Fecha Categoría</th><th>Modificar</th></tr> \n"; 
                       do {
                       echo "<tr><td>".$row["lineas"]."</td><td>".$row["fun_cod"]."</td><td>".$row["cat_des"]."</td><td>".number_format($row["cat_nom"], 0, '', '.')."</td><td>".$row["fun_ci"]."</td><td>".$row["fun_nom"]."</td><td>".$row["fun_ape"]."</td><td>".$row["cad_fec"]."</td><td><span class='editar' value='".$row["fun_cod"]."' , OnClick='Modificar(".$row["fun_cod"].");'>Editar</span></td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                       echo "</br>";
                    }  else 
                        { 
                        echo "<p align=center>";
                        echo "¡ No se ha encontrado ningún registro !"; 
                        echo "</p>";
                        }
                  
                    ?> 
        </div>
   <div class='clearfix'></div>
   </div>
  <a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
</body>
    
    
</html>
