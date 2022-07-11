<?php
date_default_timezone_set('America/Mexico_City');

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
	




	//######################################################################################
	function obtieneSucursalesInsumo($idSucursal){

		$query1=" SELECT * FROM tbl_RelSucursalIns WHERE id_Sucursal=".$idSucursal." ";
		$rquery1=mssql_query($query1);
		while($arrayQuery1 = mssql_fetch_array($rquery1)){
			$Insumos = explode(",",$arrayQuery1['st_Insumos']);
		
		}
		var_dump($Insumos);
	

		$tablaSucursales="";
		$query1 = "SELECT * FROM cat_CEDInsumos WHERE i_Activo=1 ORDER BY id_AreaInsumos";
		$rquery1 = mssql_query($query1);

		$tablaSucursales.="
			<table border='0'>
	        	<thead style='background-color:#3C78B4;'>
	                <th>INSUMOS</th>
	            </thead>
	            <tr>
	            	<th>
				    	<input type='checkbox' id='selectall' value = '0'>				    
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
						<td><input type='checkbox' class='case' id='chk".$i."' name='chk".$i."' value='".$rowdata['id_Insumo']."'"; 
				
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
						<td><input type='checkbox' class='case' id='chk".$i."' name='chk".$i."' value='".$rowdata['id_Insumo']."'"; 
				
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















	//######################################################################################

		
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