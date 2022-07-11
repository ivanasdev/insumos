<?php
function limpia_espacios($cadena){
    $cadena = str_replace(' ', '', $cadena);
    return $cadena;
}

$ruta2index = "../../../../";
include($ruta2index."dbConexion.php");
session_start();


if( !isset($_POST["idInsumo"],$_POST["stDescripcion"],$_POST["idAreaInsumos"]) ){
	
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

$idInsumo = $_POST["idInsumo"];
$stDescripcion = strtoupper( utf8_decode( trim($_POST["stDescripcion"]) ) );
$idAreaInsumos = $_POST["idAreaInsumos"];	
$iActivo = $_POST["iActivo"];
$st_Zona = $_POST["sucursales"];
$idOperador = $_SESSION["id_SysUser"];	

////////////// Valida los campos
if(trim($stDescripcion) == ""){
		$banError++;
}
	
//////	
if($banError == 0):

	// $query2 = "UPDATE cat_CEDInsumos SET st_Nombre = '".$stDescripcion."', id_AreaInsumos = '".$idAreaInsumos."', i_Activo = '".$iActivo."', id_SysUser = '".$idOperador."' WHERE id_Insumo = '".$idInsumo."'";

	$query2 = "UPDATE cat_CEDInsumos SET st_Nombre = '".$stDescripcion."', id_AreaInsumos = '".$idAreaInsumos."', 
	i_Activo = '".$iActivo."', id_SysUser = '".$idOperador."' , st_Zona = '".$st_Zona."' WHERE id_Insumo = '".$idInsumo."'";
	$rquery2 = mssql_query($query2);			

endif;
	
	
//$elementosFallo = substr($elementosFallo, 0, -1); 

if($banError == 0){
	$respuesta = array(
		'error' => '0',
		'mensaje' => 'Se Actualizó Correctamente el Insumo!!',
		'idInsumo' => $idInsumo);
}
else{
	$respuesta = array(
		'error' => '1',
		'mensaje' => 'Ocurrió un error, vuelve a intentarlo más tarde');
}

echo json_encode($respuesta); 

?>