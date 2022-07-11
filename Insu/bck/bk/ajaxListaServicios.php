<?php
$ruta2index = "../../../../";
require($ruta2index.'dbConexion.php');

include($ruta2index."bionline/securitylayer/clases/class.Catalogos.php");
$objCatalogos = new Catalogos();


$_GET["id_Sucursal"] = 0;

if( !isset($_GET["id_Sucursal"]) ){	
	echo 'Parametros incorrectos vuelve a realizar la busqueda!!';
	exit;	
}
else{
	$idSucursal = $_GET["id_Sucursal"];
}
	
	$query0 = "SELECT 
		t1.id_ServiciosMaster,
		t1.st_Codigo, 
		t1.st_Nombre, 
		t1.st_Descripcion, 
		t1.i_Costo, 
		t1.i_Activo, 
		t1.i_CostoReal, 
		t1.id_Sucursal,
		ISNULL(t2.st_Nombre,'TODAS') as nombreSucursal
	FROM cat_ServiciosMaster t1
	LEFT JOIN cat_SucursalClinica t2 ON t1.id_Sucursal = t2.id_SucursalClinica
	ORDER BY t1.id_Sucursal, t1.st_Nombre";



	$rquery0 = mssql_query($query0);

	$listado = "";
	$total = 0;
	
	while( $arrayQuery0 = mssql_fetch_array($rquery0) ){ 
		
		$idServiciosMaster = $arrayQuery0['id_ServiciosMaster'];
		$stCodigo = $arrayQuery0['st_Codigo'];
		$stNombre = $objCatalogos->mostrar($arrayQuery0['st_Nombre']);
		$stDescripcion = $objCatalogos->mostrar($arrayQuery0['st_Descripcion']);
		$iCosto = $arrayQuery0['i_Costo'];
		$iCostoReal = $arrayQuery0['i_CostoReal'];
		$iActivo = ($arrayQuery0['i_Activo'] == 1)? 'SI' : 'NO';
		$nombreSucursal = $objCatalogos->mostrar($arrayQuery0['nombreSucursal']);
		$acciones = '<a href="detalleServicio.php?id_Servicio='.$idServiciosMaster.'">Editar</a>';
							
		$listado .= '
		<tr>
		<td>'.$stCodigo.'</td>
		<td>'.$stNombre.'</td>
		<td width="400px">'.$stDescripcion.'</td>
		<td><center>'.$iCostoReal.'</center></td>
		<td><center>'.$iCosto.'</center></td>
		<td><center>'.$iActivo.'</center></td>
		<td><center>'.$nombreSucursal.'</center></td>
		<td>'.$acciones.'</td>
		</tr>';
	}	
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<div>

<table class="display" id="example">
    <thead>
        <tr class="info">   
        	<th>C&oacute;digo</th>                            
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Costo</th> 
            <th>Precio Venta</th>
            <th>Activo</th>
            <th>Sucursal</th> 
            <th>Editar</th>                                                                 
        </tr>                           
    </thead>
    <tbody> 
   <?=$listado?>
    </tbody>
    <tfoot>
		 <tr>
            <th>Columna</th>
            <th>Columna</th>
            <th>Columna</th>
            <th>Columna</th>
            <th>Columna</th>
            <th>Columna</th>
            <th>Columna</th>
            <th>Columna</th>
        </tr>
    </tfoot>	
</table>
</div>

</body>
</html>