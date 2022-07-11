<?php

$ruta2index = "../../../../";
require($ruta2index . 'dbConexion.php');

$good= "<script>alert('Se han guardado los coampos')</script>";
$Errores="<script>alert('Error en general')</script>";





if(isset($_POST['submit']) ){
	$idsucursal=$_POST['idSucursal'] ;
	$boxes=$_POST['chk'];
	$separacion=implode(",",$boxes);
	$query="UPDATE tbl_RelSucursalIns SET st_Insumos='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
	$resq=mssql_query($query);
	if($resq){
		echo $good;
	}



}




    
    

	

	//$query2 = "UPDATE tbl_RelSucursalIns SET st_Insumos=".$cadenaInsumos."  WHERE id_Sucursal = ".$idsucursal."  ";
	//$rquery2 = mssql_query($query2);		








?>


