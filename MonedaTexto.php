<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function convertirMonto($monto) 
{
    $maximo = pow(10,9);
	$unidad            = array(1=>"uno", 2=>"dos", 3=>"tres", 4=>"cuatro", 5=>"cinco", 6=>"seis", 7=>"siete", 8=>"ocho", 9=>"nueve");
	$decena            = array(10=>"diez", 11=>"once", 12=>"doce", 13=>"trece", 14=>"catorce", 15=>"quince", 20=>"veinte", 30=>"treinta", 40=>"cuarenta", 50=>"cincuenta", 60=>"sesenta", 70=>"setenta", 80=>"ochenta", 90=>"noventa");
	$prefijo_decena    = array(10=>"dieci", 20=>"veinti", 30=>"treinta y ", 40=>"cuarenta y ", 50=>"cincuenta y ", 60=>"sesenta y ", 70=>"setenta y ", 80=>"ochenta y ", 90=>"noventa y ");
	$centena           = array(100=>"cien", 200=>"doscientos", 300=>"trescientos", 400=>"cuantrocientos", 500=>"quinientos", 600=>"seiscientos", 700=>"setecientos", 800=>"ochocientos", 900=>"novecientos");	
	$prefijo_centena   = array(100=>"ciento ", 200=>"doscientos ", 300=>"trescientos ", 400=>"cuantrocientos ", 500=>"quinientos ", 600=>"seiscientos ", 700=>"setecientos ", 800=>"ochocientos ", 900=>"novecientos ");
	$sufijo_miles      = "mil";
	$sufijo_millon     = "un millon";
	$sufijo_millones   = "millones";
    
	$base         = strlen(strval($monto));
	$pren         = intval(floor($monto/pow(10,$base-1)));
	$prencentena  = intval(floor($monto/pow(10,3)));
	$prenmillar   = intval(floor($monto/pow(10,6)));
	$resto        = $monto%pow(10,$base-1);
	$restocentena = $monto%pow(10,3);
	$restomillar  = $monto%pow(10,6);
	
	if (!$monto) return "";
	
    if (is_int($monto) && $monto>0 && $monto < abs($maximo)) 
    {            
		switch ($base) {
			case 1: return $unidad[$monto];
			case 2: return array_key_exists($monto, $decena)  ? $decena[$monto]  : $prefijo_decena[$pren*10]   . convertirMonto($resto);
			case 3: return array_key_exists($monto, $centena) ? $centena[$monto] : $prefijo_centena[$pren*100] . convertirMonto($resto);
			case 4: case 5: case 6: return ($prencentena>1) ? convertirMonto($prencentena). " ". $sufijo_miles . " " . convertirMonto($restocentena) : $sufijo_miles;
			case 7: case 8: case 9: return ($prenmillar>1)  ? convertirMonto($prenmillar). " ". $sufijo_millones . " " . convertirMonto($restomillar)  : $sufijo_millon. " " . convertirMonto($restomillar);
		}
    } else {
        echo "ERROR con el numero - $monto<br/> Debe ser un numero entero menor que " . number_format($maximo, 0, ".", ",") . ".";
    }
    return $texto;
}
?>
