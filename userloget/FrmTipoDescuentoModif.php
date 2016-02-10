
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
        <title>Tipo Descuentos</title>
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
             
           window.location("http://192.168.0.99/web/phpsueldos2015/principal.php")
           
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
$result = pg_query("SELECT tde_cod,tde_des FROM tipo_descuento where tde_cod= ".$codigo); 
$row = pg_fetch_array($result);

?>
    </head>
    <body>
        <?php include("principal.php");?>
          <div id="twitter">
     
        <div class='clearfix'></div>
        

                    <div id="twitter">
                        <form autocomplete="off" action="clases/ClsTipoDescuento.php?nuevo=2" method="post" onClik="submit" > 
                                                        <div id='name' class='outerDiv'>
							<input type="hidden" name="txtcodigo" value="<?php echo $row['tde_cod'];?>" required  /> 
							<div class='message' id='nameDiv'></div>
                                                            </div>
						<div id='name' class='outerDiv'>
                                                    
							<label for="txtDescuentos">Descripción:</label> 
							<input type="text" name="txtDescuentos" value="<?php echo $row['tde_des'];?>" required  /> 
							<div class='message' id='nameDiv'> Ingrese tipo descuento </div>
						</div>
                                                <div class='clearfix'></div>
                                                <div align="center" id='submit' class='outerDiv'>
                                                <input type="submit" name="submit" value="Guardar" />
                                               <input type="button" name="cancel" value="Cancelar" onclick="window.location='http://192.168.0.99/web/phpsueldos2015/userloget/principal.php'"/>  
                                                </div>
                            </form>       
                          
                            </div>
        </br></br></br></br></br>
        <div class="centerTable" >
             <?php 
                  
                  // include './funciones.php';
                   //hace una conexion local
                     // conexionlocal();
                      $result = pg_query("SELECT row_number()over (partition by 0 order by tde_cod) as   lineas, tde_cod,tde_des  FROM tipo_descuento order by tde_cod"); 
                    if ($row = pg_fetch_array($result)){ 
                       echo "<table style='margin: 6 auto;' heigth=100% width=80% bgcolor='white' border='5' bordercolor='black' cellspacing='3' cellpadding='3' onclick='Refrescar();'> \n"; 
                      echo " <caption>Modificar Tipos Descuentos (Presione Ctrl+F para buscar)</caption>"; 
                       echo "<th>Línea</th><th>Código</th><th>Descripción</th><th>Modificar</th> \n"; 
                       do { 
                       echo "<tr><td>".$row["lineas"]."</td><td>".$row["tde_cod"]."</td><td>".$row["tde_des"]."</td><td><span class='editar' value='".$row["tde_cod"]."' , OnClick='Modificar(".$row["tde_cod"].");'>Editar</span></td></tr> \n"; 
                       } while ($row = pg_fetch_array($result)); 
                       echo "</table> \n"; 
                       echo "</br>";
                    }  else 
                        { 
                        echo "¡ No se ha encontrado ningún registro !"; 
                        }
                  
                    ?> 
        </div>
  </div>
<a href="#top"><img src="img/up.png" title="Ir arriba" style="position: fixed; bottom: 50px; left: 6%;" /></a>
    </body>
    
    
</html>
