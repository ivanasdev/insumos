<?php
function limpia_espacios($cadena){
    $cadena = str_replace(' ', '', $cadena);
    return $cadena;
}

$ruta2index = "../../../../";
include($ruta2index."dbConexion.php");
session_start();


if( !isset($_POST["stDescripcion"],$_POST["idAreaInsumos"]) ){
	
	$respuesta = array(
		'error' => '1',
		'mensaje' => 'Error, Parámetros Incorrectos!!!');
	echo json_encode($respuesta);
	exit; 	
}


$banError = 0;
$respuesta = array(
		'error' => '0',
		'mensaje' => '');

$stDescripcion = strtoupper( utf8_decode( trim($_POST["stDescripcion"]) ) );
$idAreaInsumos = $_POST["idAreaInsumos"];	
$idOperador = $_SESSION["id_SysUser"];	

////////////// Valida los campos
if(trim($stDescripcion) == ""){
		$banError++;
}
	
//////	
if($banError == 0):

	$query2 = "INSERT INTO cat_CEDInsumos (st_Nombre, id_AreaInsumos, id_SysUser) 
	VALUES ('".$stDescripcion."','".$idAreaInsumos."','".$idOperador."')";
	$rquery2 = mssql_query($query2);
	
	$query3 = "SELECT SCOPE_IDENTITY() as idInsumo";
	$rquery3 = mssql_query($query3);
	$arrayQuery3 = mssql_fetch_array($rquery3);
	$idInsumo = $arrayQuery3['idInsumo'];				

endif;
	
	
//$elementosFallo = substr($elementosFallo, 0, -1); 

if($banError == 0){
	$respuesta = array(
		'error' => '0',
		'mensaje' => 'Insertado Correctamente el Insumo!!',
		'idInsumo' => $idInsumo);
}
else{
	$respuesta = array(
		'error' => '1',
		'mensaje' => 'Ocurrió un error, vuelve a intentarlo más tarde');
}

echo json_encode($respuesta); 

?>