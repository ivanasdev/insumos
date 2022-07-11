<?php
date_default_timezone_set('America/Mexico_City');
  /*http://192.168.0.251/bionline/securitylayer/catalogos/insumos2022/insumos.php */
class Catalogos{
		

	//######################################################################################
	function obtieneSucursales($id = ""){
		$query0 = "SELECT id_SucursalClinica, UPPER(st_Nombre) as nombreSucursal FROM cat_SucursalClinica 
		WHERE id_SucursalClinica NOT IN ('0','10','50','60','61','62','63','74','75','83') AND i_Activo = '1'
		AND id_TipoSucursal != '9'
		ORDER BY st_Nombre";
		$rquery0 = mssql_query($query0);
		while( $arrayQuery0 = mssql_fetch_array($rquery0) ){		
			$selected = ($arrayQuery0['id_SucursalClinica'] == $id)? 'selected="selected"' : '';
			$resultado .= "<option value='".$arrayQuery0['id_SucursalClinica']."' ".$selected.">".$this->mostrar($arrayQuery0['nombreSucursal'])."</option>";
		}
		return $resultado;
	}//Fin Metodo obtieneSucursales

	
		//######################################################################################
	
	//######################################################################################
	function obtieneAreasInsumo($id = ""){
		$query0 = "SELECT id_AreaInsumos, UPPER(st_Nombre) as nombreArea FROM cat_AreaInsumos 
		WHERE i_Activo = '1' ORDER BY st_Nombre";
		$rquery0 = mssql_query($query0);
		while( $arrayQuery0 = mssql_fetch_array($rquery0) ){		
			$selected = ($arrayQuery0['id_AreaInsumos'] == $id)? 'selected="selected"' : '';
			$resultado .= "<option value='".$arrayQuery0['id_AreaInsumos']."' ".$selected.">".$this->mostrar($arrayQuery0['nombreArea'])."</option>";
		}
		return $resultado;
	}//Fin Metodo obtieneSucursales	
	
	
	//######################################################################################
	function obtieneAreasInsumoSucursal($idSucursal){
		
		$query1 = "SELECT * FROM cat_CEDInsumos WHERE id_AreaInsumos=2 AND i_Activo=1 ";
		$rquery1 = mssql_query($query1);
		$arrayQuery1 = mssql_fetch_array($rquery1);
		$stAlmacenes = $arrayQuery1['st_Almacenes'];
		
		$query0 = "SELECT id_AreaInsumos, UPPER(st_Nombre) as nombreArea FROM cat_AreaInsumos 
		WHERE i_Activo = '1' AND id_AreaInsumos IN (".$stAlmacenes.") ORDER BY st_Nombre";
		$rquery0 = mssql_query($query0);
		while( $arrayQuery0 = mssql_fetch_array($rquery0) ){		
			$resultado .= "<option value='".$arrayQuery0['id_AreaInsumos']."' ".$selected.">".$this->mostrar($arrayQuery0['nombreArea'])."</option>";
		}
		return $resultado;
	}//Fin Metodo obtieneSucursales		
	



	/*----------------------------------------------AREAS INSUMOS ----------------------------------------------------------------------------------------- */

	function GetAreas($idSucursal){
		$query0="SELECT st_AreasInsumos FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
		$res0=mssql_query($query0);
		while($arryareas=mssql_fetch_array($res0)){
			$AreasInusmos=explode(",",$arryareas['st_AreasInsumos']);
		}
		$checkareas="";
		$query1="SELECT * FROM cat_AreaInsumos WHERE id_AreaInsumos not in(1,7) ";
		$resq=mssql_query($query1);
		while($rowareas=mssql_fetch_array($resq)){
			$checkareas.="
			<label for=''>".$this->mostrar($rowareas['st_Nombre'])."</label>";
			$checkareas.=" <input  type='checkbox' name='areas'  id='chkareas' value='".$rowareas['id_AreaInsumos']."' ";
			if(in_array($rowareas['id_AreaInsumos'],$AreasInusmos))
			$checkareas.="checked";
			$checkareas.=" />";
		}
	
		return $checkareas;	
	}


	//######################################################################################
		function obtieneSucursalesInsumo($idSucursal){
         

		$tablaSucursales="";





		$query1=" SELECT * FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
		$rquery1=mssql_query($query1);
		while($arrayQuery1 = mssql_fetch_array($rquery1)){
			$Insumos = explode(",",$arrayQuery1['st_InsumosA2']);
		
		}
		//var_dump($Insumos);

		
		$query1 = "SELECT * FROM cat_CEDInsumos WHERE i_Activo=1 AND id_AreaInsumos=2  ORDER BY id_AreaInsumos";
		$rquery1 = mssql_query($query1);

		$tablaSucursales.="
			<table border='0'>
	        	<thead style='background-color:#3C78B4;'>
	                <th>INSUMOS AREA MEDICA</th>
	            </thead>
	            <tr>
	            	<th>
				    	<input type='checkbox' id='selectallAM' value = '0'>				    
						Seleccionar todos
					</th>
				</tr>
		";

		$i = 1;
		while($rowdata=mssql_fetch_array($rquery1)){

			if($i % 2 == 0)
			{
				$tablaSucursales.="
					<tr>
						<td><input type='checkbox' class='caseAM' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
				
						if(in_array($rowdata['id_Insumo'],$Insumos))
							$tablaSucursales.=" checked ";
						
						$tablaSucursales.="  />".$rowdata['id_Insumo']."/ ".utf8_encode($rowdata['st_Nombre']) ."  / ".$rowdata['id_AreaInsumos']." </td>
								</tr>
				";
			}
			else
			{
				$tablaSucursales.="
					<tr style='background-color:#fafafa;'>
						<td><input type='checkbox' class='caseAM' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
				
						if(in_array($rowdata['id_Insumo'],$Insumos))
							$tablaSucursales.=" checked ";
						
						$tablaSucursales.=" />".$rowdata['id_Insumo']."/".utf8_encode($rowdata['st_Nombre']) ."</td>
								</tr>
				";
			}
			$i++;
		}
		$tablaSucursales.='</table>';
		// $tablaSucursales.='<div>Ids '.var_dump($sucursalesZona).'</div>';
		return $tablaSucursales;		
	}//Fin Metodo obtieneSucursalesInsumo	
//#################################################################################################################################################################################################//

function obtieneSucursalesInsumoOP($idSucursal){

	$query0=" SELECT * FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
	$rquery0=mssql_query($query0);
	while($arrayQuery1 = mssql_fetch_array($rquery0)){
		$Insumos = explode(",",$arrayQuery1['st_InsumosA3']);
	
	}
	//var_dump($Insumos);


	$tablaSucursales="";
	$query1 = "SELECT * FROM cat_CEDInsumos WHERE i_Activo=1 AND id_AreaInsumos=3 ORDER BY id_AreaInsumos";
	$rquery1 = mssql_query($query1);

	$tablaSucursales.="
		<table border='0'>
			<thead style='background-color:#3C78B4;'>
				<th>INSUMOS OPTICA </th>
			</thead>
			<tr>
				<th>
					<input type='checkbox' id='selectallOP' value = '0'>				    
					Seleccionar todas los insumos
				</th>
			</tr>
	";

	$i = 1;
	while($rowdata=mssql_fetch_array($rquery1)){

		if($i % 2 == 0)
		{
			$tablaSucursales.="
				<tr>
					<td><input type='checkbox' class='caseOP' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.="  />".$rowdata['id_Insumo']."/ ".utf8_encode($rowdata['st_Nombre']) ."  / ".$rowdata['id_AreaInsumos']." </td>
							</tr>
			";
		}
		else
		{
			$tablaSucursales.="
				<tr style='background-color:#fafafa;'>
					<td><input type='checkbox' class='caseOP' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.=" />".$rowdata['id_Insumo']."/".utf8_encode($rowdata['st_Nombre']) ."</td>
							</tr>
			";
		}
		$i++;
	}
	$tablaSucursales.='</table>';
	// $tablaSucursales.='<div>Ids '.var_dump($sucursalesZona).'</div>';
	return $tablaSucursales;		
}//Fin Metodo obtieneSucursalesInsumo	


function obtieneSucursalesInsumoDEN($idSucursal){

	$query1=" SELECT * FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
	$rquery1=mssql_query($query1);
	while($arrayQuery1 = mssql_fetch_array($rquery1)){
		$Insumos = explode(",",$arrayQuery1['st_InsumosA4']);
	
	}
	//var_dump($Insumos);


	$tablaSucursales="";
	$query1 = "SELECT * FROM cat_CEDInsumos WHERE i_Activo=1 AND id_AreaInsumos=4 ";
	$rquery1 = mssql_query($query1);

	$tablaSucursales.="
		<table border='0'>
			<thead style='background-color:#3C78B4;'>
				<th>INSUMOS DENTAL </th>
			</thead>
			<tr>
				<th>
					<input type='checkbox' id='selectallDEN' value = '0'>				    
					Seleccionar todos los insumos
				</th>
			</tr>
	";

	$i = 1;
	while($rowdata=mssql_fetch_array($rquery1)){

		if($i % 2 == 0)
		{
			$tablaSucursales.="
				<tr>
					<td><input type='checkbox' class='caseDEN' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.="  />".$rowdata['id_Insumo']."/ ".utf8_encode($rowdata['st_Nombre']) ."  / ".$rowdata['id_AreaInsumos']." </td>
							</tr>
			";
		}
		else
		{
			$tablaSucursales.="
				<tr style='background-color:#fafafa;'>
					<td><input type='checkbox' class='caseDEN' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.=" />".$rowdata['id_Insumo']."/".utf8_encode($rowdata['st_Nombre']) ."</td>
							</tr>
			";
		}
		$i++;
	}
	$tablaSucursales.='</table>';
	// $tablaSucursales.='<div>Ids '.var_dump($sucursalesZona).'</div>';
	return $tablaSucursales;		
}//Fin Metodo obtieneSucursalesInsumo	






function obtieneSucursalesInsumoLAB($idSucursal){

	$query1=" SELECT * FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
	$rquery1=mssql_query($query1);
	while($arrayQuery1 = mssql_fetch_array($rquery1)){
		$Insumos = explode(",",$arrayQuery1['st_InsumosA5']);
	
	}
	//var_dump($Insumos);


	$tablaSucursales="";
	$query1 = "SELECT * FROM cat_CEDInsumos WHERE i_Activo=1 AND id_AreaInsumos=5";
	$rquery1 = mssql_query($query1);

	$tablaSucursales.="
		<table border='0'>
			<thead style='background-color:#3C78B4;'>
				<th>INSUMOS LABORATORIO </th>
			</thead>
			<tr>
				<th>
					<input type='checkbox' id='selectallLAB' value = '0'>				    
					Seleccionar todos los insumos
				</th>
			</tr>
	";

	$i = 1;
	while($rowdata=mssql_fetch_array($rquery1)){

		if($i % 2 == 0)
		{
			$tablaSucursales.="
				<tr>
					<td><input type='checkbox' class='caseLAB' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.="  />".$rowdata['id_Insumo']."/ ".utf8_encode($rowdata['st_Nombre']) ."  / ".$rowdata['id_AreaInsumos']." </td>
							</tr>
			";
		}
		else
		{
			$tablaSucursales.="
				<tr style='background-color:#fafafa;'>
					<td><input type='checkbox' class='caseLAB' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.=" />".$rowdata['id_Insumo']."/".utf8_encode($rowdata['st_Nombre']) ."</td>
							</tr>
			";
		}
		$i++;
	}
	$tablaSucursales.='</table>';
	// $tablaSucursales.='<div>Ids '.var_dump($sucursalesZona).'</div>';
	return $tablaSucursales;		
}//Fin Metodo obtieneSucursalesInsumo	





function obtieneSucursalesInsumoGIN($idSucursal){

	$query1=" SELECT * FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
	$rquery1=mssql_query($query1);
	while($arrayQuery1 = mssql_fetch_array($rquery1)){
		$Insumos = explode(",",$arrayQuery1['st_InsumosA6']);
	
	}
	//var_dump($Insumos);


	$tablaSucursales="";
	$query1 = "SELECT * FROM cat_CEDInsumos WHERE i_Activo=1 AND id_AreaInsumos=6 ORDER BY id_AreaInsumos";
	$rquery1 = mssql_query($query1);

	$tablaSucursales.="
		<table border='0'>
			<thead style='background-color:#3C78B4;'>
				<th>INSUMOS GINECOLOGIA </th>
			</thead>
			<tr>
				<th>
					<input type='checkbox' id='selectallGIN' value = '0'>				    
					Seleccionar todos los insumos
				</th>
			</tr>
	";

	$i = 1;
	while($rowdata=mssql_fetch_array($rquery1)){

		if($i % 2 == 0)
		{
			$tablaSucursales.="
				<tr>
					<td><input type='checkbox' class='caseGIN' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.="  />".$rowdata['id_Insumo']."/ ".utf8_encode($rowdata['st_Nombre']) ."   </td>
							</tr>
			";
		}
		else
		{
			$tablaSucursales.="
				<tr style='background-color:#fafafa;'>
					<td><input type='checkbox' class='caseGIN' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
			
					if(in_array($rowdata['id_Insumo'],$Insumos))
						$tablaSucursales.=" checked ";
					
					$tablaSucursales.=" />".$rowdata['id_Insumo']."/".utf8_encode($rowdata['st_Nombre']) ."</td>
							</tr>
			";
		}
		$i++;
	}
	$tablaSucursales.='</table>';
	// $tablaSucursales.='<div>Ids '.var_dump($sucursalesZona).'</div>';
	return $tablaSucursales;		
}//Fin Metodo obtieneSucursalesInsumo	







//·································································································································································································//










	function mostrar($cadena){
		return utf8_encode(trim($cadena));
	}
	
	function poner($cadena){
		return utf8_decode(trim($cadena));
	}
	
	function mostrarFecha($cadena){
		
		if($cadena == '1900-01-01' || $cadena == NULL || trim($cadena) == "" )
			return "";
		else
			return utf8_decode( date('Y/m/d',strtotime($cadena)) );
			
	}

   
}//Fin Class Catalogos
?>