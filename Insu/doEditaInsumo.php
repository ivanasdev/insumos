<?php

$ruta2index = "../../../../";
require($ruta2index . 'dbConexion.php');

$good= "<script>alert('Se han guardado los coampos')</script>";
$Errores="<script>alert('Error en general')</script>";





    $flag=$_POST['flag'];

	if(isset($flag) && $flag !== ""){
		switch($flag)
		{
			
			case "areas";
			    $idsucursal=$_POST['idSucursal'] ;
			    $areas=$_POST['areas'];
			    $separacion=implode(",",$areas);
			    $query="UPDATE tbl_RelSucursalInsumosA SET st_AreasInsumos='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
			    $resq=mssql_query($query);
			    echo $query;
			    break;

			case "am":
				$idsucursal=$_POST['idSucursal'] ;
				$boxes=$_POST['chk'];
				$separacion=implode(",",$boxes);
				$query="UPDATE tbl_RelSucursalInsumosA SET st_InsumosA2='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
				$resq=mssql_query($query);
				echo $query;
				break;
			case "op":
				$idsucursal=$_POST['idSucursal'] ;
				$boxes=$_POST['chk'];
				$separacion=implode(",",$boxes);	
				$query="UPDATE tbl_RelSucursalInsumosA SET st_InsumosA3='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
				$resq=mssql_query($query);
				break;
			case  "den":
				$idsucursal=$_POST['idSucursal'] ;
				$boxes=$_POST['chk'];
				$separacion=implode(",",$boxes);
				$query="UPDATE tbl_RelSucursalInsumosA SET st_InsumosA4='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
				$resq=mssql_query($query);
				break;
			case "lab":
				$idsucursal=$_POST['idSucursal'] ;
				$boxes=$_POST['chk'];
				$separacion=implode(",",$boxes);	
				$query="UPDATE tbl_RelSucursalInsumosA SET st_InsumosA5='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
				$resq=mssql_query($query);
				break;
			case "gin":
				$idsucursal=$_POST['idSucursal'] ;
				$boxes=$_POST['chk'];
				$separacion=implode(",",$boxes);	
				$query="UPDATE tbl_RelSucursalInsumosA SET st_InsumosA6='".$separacion."'  WHERE id_Sucursal=".$idsucursal."   ";
				$resq=mssql_query($query);
				break;


			
			
			
			
		
		}
		
		
		



	}








    
    

	

	//$query2 = "UPDATE tbl_RelSucursalIns SET st_Insumos=".$cadenaInsumos."  WHERE id_Sucursal = ".$idsucursal."  ";
	//$rquery2 = mssql_query($query2);		








?>


