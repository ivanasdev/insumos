<?php
$ruta2index = "../../../../";
require($ruta2index . 'dbConexion.php');


if (!isset($_GET["idSucursal"])) {
	echo "Parametro Incorrecto";
	exit;
}

$idSucursal = $_GET["idSucursal"];
echo $idSucursal;






/////////////////////////////////////// Obtiene Sucursales ////////////
include("class.Catalogos.php");
$objCatalogos = new Catalogos();
//////////////////////////////////////////////////////////////////////
$selectAreasInsumo = $objCatalogos->obtieneAreasInsumo($idSucursal);
$checkBoxSucursalesInsumo = $objCatalogos->obtieneSucursalesInsumo($idSucursal);



?>

<!DOCTYPE html>
<html lang="es">

<head>

	<script type="text/javascript" src="<?= $ruta2index ?>utils/jquery-1.11.1.min.js"></script>

	<link rel="stylesheet" href="<?= $ruta2index ?>bionline/securitylayer/styles/styleTrasnparentBody.css" type="text/css">
	<link href="<?= $ruta2index ?>bionline/securitylayer/styles/style_botones.css" rel="stylesheet" type="text/css">



	<style type="text/css">
		#tablaForm td {
			height: 30px;
		}

		body {
			background-color: #EEE;
		}
	</style>


	<script type="text/javascript">
	function editaInsumos() {
		var datastring = $("#formPrincipal").serialize();
		$.ajax({
				type: "POST",
				url: "doEditaInsumo.php",
				data: datastring,
				dataType: "json",
				beforeSend: function() {
					$("#btnEnviar").attr("disabled", "disabled");
				},
				success: function(data) {

					//$('#refreshPagina', window.parent.document).val(1);
					alert("Todo fine")
;
				},
			
			});

		}
		$(document).ready(function() { // Handler for .ready() called.
			// add multiple select/unselect functionality
			$("#selectall").on("click", function() {
				$(".case").prop("checked", this.checked);
			});

			// if all checkbox are selected, check the selectall checkbox and viceversa  
			$(".case").on("click", function() {
				if ($(".case").length == $(".case:checked").length) {
					$("#selectall").prop("checked", true);
				} else {
					$("#selectall").prop("checked", false);
				}
			});

			function sucursalesInsumos() {
				var total = $("input[type=checkbox]:checked").length;
				console.log(total);
				// var unoAntes = total - 1;
				var insumos;
				insumos = "";

				$("input[type=checkbox]:checked").each(function() {
					insumos += ($(this).val()) + ",";
				});

				// if (unoAntes < total) {

				// } else {
				// 	$("input[type=checkbox]:checked").each(function() {
				//  	insumos+=($(this).val());
				//	});
				// }    

				$('#insumos').val(insumos);
				console.log(insumos);
			}

			//SUBMIT
			$("#formPrincipal").on("submit", function(e) {
				//e.preventDefault();
				sucursalesInsumos();
				editaInsumos();
				//return false;		
			})
		});
	</script>

</head>


<body>

	<input type="hidden" name="refreshPagina" id="refreshPagina" value="0" />


	<table>
		<tr>

			<td><img src="<?= $ruta2index ?>bionline/securitylayer/images/statistics.gif" width="48" height="48"></td>
			<td><strong>EDICION DE INSUMO</strong></td>

		</tr>
	</table>

	<form id="formPrincipa" method="POST" action="doEditaInsumo.php" >
		<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $idSucursal; ?>" />
		<table id="tablaForm">
			<tr>
				<!-- <td>Seleccionar sucursal: </td> -->
				<!-- <td> -->
				<?= $checkBoxSucursalesInsumo ?>
				<!-- </td> -->
			</tr>

			<tr>
				<td colspan="2" align="center">
					<input type="submit" id="btnEnviar" name="submit" value="Enviar" class="botonAzul">
					<!--<input type='hidden' value='' id='insumos' name='insumos' />-->
				</td>
			</tr>

		</table>
	</form>

</body>


</html>