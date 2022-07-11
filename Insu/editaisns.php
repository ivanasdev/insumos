<?php
$ruta2index = "../../../../";
require($ruta2index . 'dbConexion.php');


if (!isset($_GET["idInsumo"])) {
	echo "Parametro Incorrecto";
	exit;
}

$idInsumo = $_GET["idInsumo"];

$query1 = "SELECT id_AreaInsumos, st_Nombre, CONVERT(TEXT, st_Zona) as st_Zona, i_Activo FROM cat_CEDInsumos WHERE id_Insumo = '" . $idInsumo . "'";
$rquery1 = mssql_query($query1);
$arrayQuery1 = mssql_fetch_array($rquery1);
$idAreaInsumos = $arrayQuery1['id_AreaInsumos'];
$stNombre = strtoupper(trim(utf8_encode($arrayQuery1['st_Nombre'])));
$st_Zona = $arrayQuery1['st_Zona'];
// $st_Zona = explode(",",$arrayQuery1['st_Zona']);
$iActivo = $arrayQuery1['i_Activo'];

/////////////////////////////////////// Obtiene Sucursales ////////////
include($ruta2index . "bionline/securitylayer/reportes/class.Catalogos.php");
$objCatalogos = new Catalogos();
//////////////////////////////////////////////////////////////////////
$selectAreasInsumo = $objCatalogos->obtieneAreasInsumo($idAreaInsumos);
$checkBoxSucursalesInsumo = $objCatalogos->obtieneSucursalesInsumo($st_Zona);

$chek1 = $check2 = '';
if ($iActivo == 0) {
	$check0 = 'SELECTED';
} else {
	$check1 = 'SELECTED';
}

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
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		function validaForm() {
			var validaForm = new Array();
			validaForm['error'] = "Se han encontrado los siguientes errores:";
			validaForm['ban'] = 0;
			if ($('#stDescripcion').val().trim() == "") {
				validaForm['error'] += "\n - Especifique Descripcion";
				validaForm['ban']++
			}
			return validaForm;
		}

		function editaInsumos() {



			var validacion = new Array();
			validacion = validaForm();
			if (validacion['ban'] > 0) {
				alert(validacion['error']);
			} else {


				var datastring = $("#formPrincipal").serialize();
				//alert(datastring);

				$.ajax({
					type: "POST",
					url: "doEditaInsumo.php",
					data: datastring,
					dataType: "json",
					beforeSend: function() {
						$("#btnEnviar").attr("disabled", "disabled");
					},
					success: function(data) {

						$('#refreshPagina', window.parent.document).val(1);

						if (data.error == 1)
							alert(data.mensaje);
						else {
							alert("Se Edit\u00f3 correctamente");
							window.parent.TINY.box.hide();
						}

						$("#btnEnviar").removeAttr("disabled");

					},
					error: function() {
						alert('Ocurrió un error, Verifica los datos');
						$("#btnEnviar").removeAttr("disabled");
					}
				});

			}

		}

		//////////////////////////////////// Valida Solo Numeros
		function soloNumeros(e) {
			key = e.keyCode || e.which;
			tecla = String.fromCharCode(key).toLowerCase();
			letras = " 0123456789";
			especiales = [8, 9, 37, 39, 46];

			tecla_especial = false
			for (var i in especiales) {
				if (key == especiales[i]) {
					tecla_especial = true;
					break;
				}
			}

			if (letras.indexOf(tecla) == -1 && !tecla_especial)
				return false;
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
				var sucursales;
				sucursales = "";

				$("input[type=checkbox]:checked").each(function() {
					sucursales += ($(this).val()) + ",";
				});

				// if (unoAntes < total) {

				// } else {
				// 	$("input[type=checkbox]:checked").each(function() {
				//  	sucursales+=($(this).val());
				//	});
				// }

				$('#sucursales').val(sucursales);
				console.log(sucursales);
			}

			//SUBMIT
			$("#formPrincipal").on("submit", function(e) {
				e.preventDefault();
				//sucursalesInsumos();
				//editaInsumos();
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

	<form id="formPrincipal">
		<input type="hidden" name="idInsumo" id="idInsumo" value="<?= $idInsumo ?>" />
		<table id="tablaForm">

			<tr>
				<td>Descripci&oacute;n: </td>
				<td>
					<input type="text" name="stDescripcion" id="stDescripcion" size="40" value="<?= $stNombre ?>" required>
				</td>
			</tr>

			<tr>
				<td>Area de Insumo: </td>
				<td>
					<select id="idAreaInsumos" name="idAreaInsumos">
						<?= $selectAreasInsumo ?>
					</select>
				</td>
			</tr>

			<tr>
				<td>Activo: </td>
				<td>
					<select id="iActivo" name="iActivo">
						<option value="0" <?= $check0 ?>>Inactivo</option>
						<option value="1" <?= $check1 ?>>Activo</option>
					</select>
				</td>
			</tr>

			<tr>
				<!-- <td>Seleccionar sucursal: </td> -->
				<!-- <td> -->
				<?= $checkBoxSucursalesInsumo ?>
				<!-- </td> -->
			</tr>

			<tr>
				<td colspan="2" align="center">
					<input type="submit" id="btnEnviar" value="Enviar" class="botonAzul">
					<input type='hidden' value='' id='sucursales' name='sucursales' />
				</td>
			</tr>

		</table>
	</form>

</body>


</html>