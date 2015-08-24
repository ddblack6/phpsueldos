
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
        
        //conecta al 192.168.56.100
        function conexionlocal()
        {
            return $dbconn = pg_connect("host=localhost port=5434 dbname=salario user=postgres password=postgres"
                    . "")or die ('Error al conectar a la base de datos');
        }
        
        
        
        
        
        
        //compara si ya existe el dato del tipo cadena
        /*
         * function func_existeDato($dato, $tabla, $columna, $database){
            selectConexion($database);
            $query = "select * from $tabla where $columna = '$dato'";
            $result = pg_query($query) or die ("Error al realizar la consulta");
            if (pg_num_rows($result)>0)
            {
               return true;
            } else {
               return false;
            }
        }
         * 
         */
                //compara si ya existe el dato del tipo numerico
        function func_existeDato($dato, $tabla, $columna, $database){
            selectConexion($database);
            $query = "select * from $tabla where $columna = '$dato' ;";
            $result = pg_query($query) or die ("Error al realizar la consulta");
            if (pg_num_rows($result)>0)
            {
               return true;
            } else {
               return false;
            }
        }
         function func_existeDatoDetalle($dato1,$dato2 ,$tabla, $columna1,$columna2, $database){
            selectConexion($database);
            $query = "select * from $tabla where $columna1 = '$dato1' and $columna2 = '$dato2' ;";
            $result = pg_query($query) or die ("Error al realizar la consulta");
            if (pg_num_rows($result)>0)
            {
               return true;
            } else {
               return false;
            }
        }
        function func_SalarioDuplicado($codFuncionario, $database){
            selectConexion($database);
            $query = "select fun_cod as CodigoFuncionario,to_char((sal_fecha), 'MONTH') as FechaSalario  
                from salario 
                where EXTRACT(MONTH FROM sal_fecha)= EXTRACT(MONTH FROM now()) 
                and EXTRACT(YEAR FROM sal_fecha)= EXTRACT(YEAR FROM now()) 
                and fun_cod=$codFuncionario ;";
            $result = pg_query($query) or die ("Error al realizar la consulta");
            if (pg_num_rows($result)>0)
            {
               return 1;
            } else {
               return 0;
            }
        }
        //funcion que selecciona a la base de Datos
        function selectConexion($database){
   
                return $conexion = conexionlocal();
           
          
        }
        function genMonth_Text($m) { 
        switch ($m) { 
         case '01': $month_text = "Enero"; break; 
         case '02': $month_text = "Febrero"; break; 
         case '03': $month_text = "Marzo"; break; 
         case '04': $month_text = "Abril"; break; 
         case '05': $month_text = "Mayo"; break; 
         case '06': $month_text = "Junio"; break; 
         case '07': $month_text = "Julio"; break; 
         case '08': $month_text = "Agosto"; break; 
         case '09': $month_text = "Septiembre"; break; 
         case '10': $month_text = "Octubre"; break; 
         case '11': $month_text = "Noviembre"; break; 
         case '12': $month_text = "Diciembre"; break; 
        } 
        return ($month_text); 
       } 
        ?>
    </body>
</html>
