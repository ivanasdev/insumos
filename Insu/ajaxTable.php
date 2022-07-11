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
	
	
	$query0 = "SELECT id_SucursalClinica, UPPER(st_Nombre) as st_Nombre FROM cat_SucursalClinica 
	WHERE id_SucursalClinica NOT IN ('0','10','50','60','61','62','63','74','75','83')
	AND id_TipoSucursal != '9' AND id_Cliente NOT IN ('3','9') AND id_RhModeloNegocio not in(16) AND i_Activo=1  order by id_SucursalClinica";


	$rquery0 = mssql_query($query0);

	$listado = "";
	$total = 0;
	
	while( $arrayQuery0 = mssql_fetch_array($rquery0) ){ 
		
		$idSucursalClinica = $arrayQuery0['id_SucursalClinica'];
		$stNombre = $objCatalogos->mostrar($arrayQuery0['st_Nombre']);

		//$iActivo = ($arrayQuery0['i_Activo'] == 1)? 'SI' : 'NO';
		$acciones = '<a href="javascript:abrirPop(\'600\',\'700\',\'editaInsumo.php?idSucursal='.$idSucursalClinica.'\')">	<img src="static/img/iconoBase2.png" style="width:40 px; height: 40px ;
		" alt="" title="ASIGNAR INSUMOS"> </a>';
		$acciones2 = '<a href="javascript:abrirPop(\'600\',\'700\',\'editaInsumo.php?idSucursal='.$idSucursalClinica.'\')">Editar</a>';
							
		$listado .= '
		<tr>
		<td align="center">'.$idSucursalClinica.'</td>
		<td>'.$stNombre.'</td>


		<td align="center">'.$acciones.'</td>

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




<!--<table id="example" class="stripe row-border order-column" cellspacing="0" width="100%">-->
<table cellpadding="0" cellspacing="0" border="0" class="cell-border hover" id="example">
    <thead>
        <tr class="info">   
        	<th>ID</th>                            
            <th>Nombre</th>
      
            <th>Asignar Insumos </th>
                                                           
        </tr>                           
    </thead>
    <tbody> 
   <?=$listado?>
    </tbody>
    <tfoot>
		 <tr>
            <th>ID</th>
            <th>Nombre</th>
         
            <th>Columna</th>
     
        </tr>
    </tfoot>	
</table>
</div>

</body>
</html>