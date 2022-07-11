<?php
$ruta2index = "../../../../";
require($ruta2index.'dbConexion.php');

/////////////////////////////////////// Obtiene Sucursales ////////////
include($ruta2index."bionline/securitylayer/reportes/class.Catalogos.php");
$objCatalogos = new Catalogos();
//////////////////////////////////////////////////////////////////////
$selectAreasInsumo = $objCatalogos->obtieneAreasInsumo();

?>

<!DOCTYPE html>
<html lang="es">

<head>

<script type="text/javascript" src="<?=$ruta2index?>utils/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" href="<?=$ruta2index?>bionline/securitylayer/styles/styleTrasnparentBody.css" type="text/css">
<link href="<?=$ruta2index?>bionline/securitylayer/styles/style_botones.css" rel="stylesheet" type="text/css">



<style type="text/css">

#tablaForm td{
	height:30px;
}
body{
	background-color:#EEE;
}

</style>


<script type="text/javascript">


///////////////////////////////////////////////////////////////////////////////////////////////////////
function validaForm(){	
	var validaForm = new Array();
	validaForm['error'] = "Se han encontrado los siguientes errores:";
	validaForm['ban']   = 0;
	if($('#stDescripcion').val().trim() == ""){validaForm['error'] += "\n - Especifique Descripcion";validaForm['ban']++}		
	return validaForm;
}		 

function agregaInsumos(){
	
	
	
	var validacion = new Array();
	validacion = validaForm();
	if(validacion['ban'] > 0){alert(validacion['error']);}
	else{
		
				
		var datastring = $("#formPrincipal").serialize();	
		//alert(datastring);

		
		$.ajax({
			type: "POST",
			url: "doAltaInsumo.php",
			data: datastring,
			dataType: "json",
			beforeSend: function(){
				$("#btnEnviar").attr("disabled", "disabled");	
			},
			success: function(data) {								
				
				$('#refreshPagina',window.parent.document).val(1);
								
				if(data.error == 1)
					alert(data.mensaje);
				else{
					alert("Se Agreg\u00f3 correctamente");
					window.parent.TINY.box.hide();
				}
					
				$("#btnEnviar").removeAttr("disabled");
								
			},
			error: function(){
				  alert('Ocurrió un error, Verifica los datos');
				  $("#btnEnviar").removeAttr("disabled");
			}
		});
		
	}
	
}

//////////////////////////////////// Valida Solo Numeros
function soloNumeros(e){
			 key = e.keyCode || e.which;
			 tecla = String.fromCharCode(key).toLowerCase();
			 letras = " 0123456789";
			 especiales = [8,9,37,39,46];

			 tecla_especial = false
			 for(var i in especiales){
				 if(key == especiales[i]){
			  tecla_especial = true;
			  break;
						} 
			 }
	 
			if(letras.indexOf(tecla)==-1 && !tecla_especial)
				return false;
		 }		 



$(document).ready(function() {// Handler for .ready() called.


	//SUBMIT
	$("#formPrincipal").on("submit", function(e){				
		e.preventDefault();	
		agregaInsumos();
		//return false;		
	})

});	

</script>

</head>


<body>

<input type="hidden" name="refreshPagina" id="refreshPagina" value="0"/>


<table>
<tr>
    
    <td><img src="<?=$ruta2index?>bionline/securitylayer/images/statistics.gif" width="48" height="48"></td>
    <td><strong>ALTA DE INSUMO</strong></td>
    
</tr>
</table>

<form id="formPrincipal">
<table id="tablaForm">

	<tr>    
        <td>Descripci&oacute;n: </td>
        <td>
        <input type="text" name="stDescripcion" id="stDescripcion" size="40" required>
        </td>
    </tr>

	<tr>    
        <td>Area de Insumo: </td>
        <td>
        <select id="idAreaInsumos" name="idAreaInsumos">
        <?=$selectAreasInsumo?>
        </select>
        </td>
    </tr>
    
    <tr>    
        <td colspan="2" align="center">
        <input type="submit" id="btnEnviar" value="Agregar" class="botonAzul">
        </td>
    </tr>
    
</table>
</form>

</body>


</html>