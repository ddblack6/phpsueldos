<?php 
session_start();
?>
<?php

/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Sueldos INTN
 */

//require_once('login.php');
include('adodb/adodb.inc.php');
include('adodb/adodb-exceptions.inc.php');
define('ADODB_ASSOC_CASE',2); //me muestra el método de como mostrar 
//los arreglos, en este caso el 2 muestra 
//los nombres de columnas en minúsculas

function obtenerConexion() 
{	
	try{
		$db =ADONewConnection('postgres');
		$db->SetFetchMode(ADODB_FETCH_ASSOC); // muestra los arreglos con asociaciones
		//$db->SetFetchMode(ADODB_FETCH_NUM); //muestra los arreglos enumerados
		//$db->Connect('127.0.0.1','postgres','postgres','horariosweb');
		$db->Connect("host=127.0.0.1 port=5432 dbname=salario user=postgres password=postgres");
		//$db->debug=true;	
	} 
	catch (exception $e) 
	{
		
		print_r($e);
	}
	return $db;
}

function query($sql)
{	
	try{
		
		$db = obtenerConexion();
		$pre =$db->Prepare($sql);
		$rs =$db->Execute(  $pre);
		if (!$rs)
		{	
			//echo "vacio";
			die($db->ErrorMsg()); 
		}
		else
		{
		return $rs->GetRows(); 
		}
	} catch (exception $e) {
		print_r($e);
	}
}

function operacion($sql)
{
	$db = obtenerConexion();
	$pre = $db->Prepare($sql);
	$rs =&$db->_Execute($pre);
	if (!$rs)
	{ 	$ret=0;
		$error = $db->ErrorMsg();
		$ret = array(0,$error);
	}
else
	{	 
		$ret = array(1); 
	}
	return $ret;
} 
	

?>