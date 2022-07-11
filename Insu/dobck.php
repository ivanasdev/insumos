<?php 
	function obtieneSucursalesInsumo($idSucursal){

		$query1=" SELECT * FROM tbl_RelSucursalIns WHERE id_Sucursal=".$idSucursal." ";
		$rquery1=mssql_query($query1);
		while($arrayQuery1 = mssql_fetch_array($rquery1)){
			$Insumos = explode(",",$arrayQuery1['st_Insumos']);
		
		}
		//var_dump($Insumos);
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
						<td><input type='checkbox' class='case' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
				
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
						<td><input type='checkbox' class='case' id='chk".$i."' name='chk[]' value='".$rowdata['id_Insumo']."'"; 
				
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

?>