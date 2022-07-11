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
//$selectAreasInsumo = $objCatalogos->obtieneAreasInsumo($idSucursal);
$checkBoxSucursalesInsumo = $objCatalogos->obtieneSucursalesInsumo($idSucursal);
$checkBoxSucursalesOP = $objCatalogos->obtieneSucursalesInsumoOP($idSucursal);
$checkBoxSucursalesInsumoDEN = $objCatalogos->obtieneSucursalesInsumoDEN($idSucursal);
$checkBoxSucursalesInsumoLAB = $objCatalogos->obtieneSucursalesInsumoLAB($idSucursal);
$checkBoxSucursalesInsumoGIN = $objCatalogos->obtieneSucursalesInsumoGIN($idSucursal);
$checkBoxareas = $objCatalogos->GetAreas($idSucursal);

/*
$query0="SELECT st_AreasInsumos FROM tbl_RelSucursalInsumosA WHERE id_Sucursal=".$idSucursal." ";
$res0=mssql_query($query0);
while($arryareas=mssql_fetch_array($res0)){
	$AreasInusmos=explode(",",$arryareas['st_AreasInsumos']);
}*/


?>

<!DOCTYPE html>
<html lang="en">

<head>

	<script type="text/javascript" src="<?= $ruta2index ?>utils/jquery-1.11.1.min.js"></script>

	<!--<link rel="stylesheet" href="<?= $ruta2index ?>bionline/securitylayer/styles/styleTrasnparentBody.css" type="text/css">-->
	<link href="<?= $ruta2index ?>bionline/securitylayer/styles/style_botones.css" rel="stylesheet" type="text/css">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


	<style type="text/css">
		#tablaForm td {
			height: 30px;
		}

		body {
			background-color: #EEE;
		}


		.card {
			background: rgba(247, 247, 247, 0.65);
			box-shadow: 0 8px 32px 0 #000000;
			backdrop-filter: blur(14px);
			-webkit-backdrop-filter: blur(14px);
			border-radius: 10px;
			border: 1px solid rgba(255, 255, 255, 0.18);
		}
	</style>



</head>


<body>

	<input type="hidden" name="refreshPagina" id="refreshPagina" value="0" />


	<table>
		<tr>
			<td><img src="<?= $ruta2index ?>bionline/securitylayer/images/statistics.gif" width="48" height="48"></td>
			<td><strong>EDICION DE INSUMO</strong></td>
		</tr>
	</table>

	<button class="btn btn-dark" style="margin:18px ;" onclick="menuareasS()" ondblclick="menuareasH()">ASIGNAR AREAS</button>
	<div class="card text-center" id="areasmenu">
		<p>
		<h6>ASIGNAR AREAS</h6>
		</p>
		<form id="formAreas">
			<div class="form-check">
				<?= $checkBoxareas ?>
			</div>
			<button class="btn btn-primary" id="btnareas">ACTUALIZAR AREAS</button>
		</form>
	</div>



	<div class="card card-bodie">
		<button type="button" class="btn btn-dark" onclick="menuAMS()" ondblclick="menuAMH()" style="margin:18px;">AREA MEDICA</button>
		<div id="AMFORM">

			<form id="formAM">
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

		</div>

		<!--OPTICA-->
		<button type="button" class="btn btn-dark" onclick="menuOPS()" ondblclick="menuOPH()" style="margin:18px;">OPTICA</button>
		<div id="OPFORM">

			<form id="formOP" method="POST" action="doEditaInsumo.php">
				<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $idSucursal; ?>" />
				<table id="tablaForm">
					<tr>

						<?= $checkBoxSucursalesOP ?>

					</tr>

					<tr>
						<td colspan="2" align="center">
							<input type="submit" id="btnEnviar" name="submit" value="Enviar" class="botonAzul">

						</td>
					</tr>

				</table>
			</form>

		</div>

		<!--DENTAL-->

		<button type="button" class="btn btn-dark" onclick="menuDENS()" ondblclick="menuDENH()" style="margin:18px;">DENTAL</button>
		<div id="DENFORM">

			<form id="FORMDEN" method="POST" action="doEditaInsumo.php">
				<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $idSucursal; ?>" />
				<table id="tablaForm">
					<tr>

						<?= $checkBoxSucursalesInsumoDEN ?>

					</tr>

					<tr>
						<td colspan="2" align="center">
							<input type="submit" id="btnEnviar" name="submit" value="Enviar" class="botonAzul">

						</td>
					</tr>

				</table>
			</form>

		</div>


		<!--LABORATORIO-->
		<button type="button" class="btn btn-dark" onclick="menuLABS()" ondblclick="menuLABH()" style="margin:18px;">LABORATORIO</button>
		<div id="LABFORM">

			<form id="FORMLAB" method="POST" action="doEditaInsumo.php">
				<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $idSucursal; ?>" />
				<table id="tablaForm">
					<tr>

						<?= $checkBoxSucursalesInsumoLAB ?>

					</tr>

					<tr>
						<td colspan="2" align="center">
							<input type="submit" id="btnEnviar" name="submit" value="Enviar" class="botonAzul">

						</td>
					</tr>

				</table>
			</form>

		</div>



		<!--GINECOLOGIA-->
		<button type="button" class="btn btn-dark" onclick="menuGINS()" ondblclick="menuGINH()" style="margin:18px;">GINECOLOGIA</button>
		<div id="GINFORM">

			<form id="FORMGIN" method="POST" action="doEditaInsumo.php">
				<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $idSucursal; ?>" />
				<table id="tablaForm">
					<tr>

						<?= $checkBoxSucursalesInsumoGIN ?>

					</tr>

					<tr>
						<td colspan="2" align="center">
							<input type="submit" id="btnEnviar" name="submit" value="Enviar" class="botonAzul">

						</td>
					</tr>

				</table>
			</form>

		</div>





	</div>




	</div>

	</div>


	<script type="text/javascript">
		$(document).ready(function() {

			$("#AMFORM").hide();
			$("#OPFORM").hide();
			$("#DENFORM").hide();
			$("#LABFORM").hide();
			$("#GINFORM").hide();
			$("#areasmenu").hide();



			$("#selectallAM").on("click", function() {
				$(".caseAM").prop("checked", this.checked);
			});
			$(".caseAM").on("click", function() {
				if ($(".caseAM").length == $(".caseAM:checked").length) {
					$("#selectallAM").prop("checked", true);
				} else {
					$("#selectallAM").prop("checked", false);
				}
			});


			$("#selectallOP").on("click", function() {
				$(".caseOP").prop("checked", this.checked);
			});
			$(".caseOP").on("click", function() {
				if ($(".caseOP").length == $(".caseOP:checked").length) {
					$("#selectallOP").prop("checked", true);
				} else {
					$("#selectallOP").prop("checked", false);
				}
			});


			$("#selectallDEN").on("click", function() {
				$(".caseDEN").prop("checked", this.checked);
			});
			$(".caseDEN").on("click", function() {
				if ($(".caseDEN").length == $(".caseDEN:checked").length) {
					$("#selectallDEN").prop("checked", true);
				} else {
					$("#selectallDEN").prop("checked", false);
				}
			});


			$("#selectallLAB").on("click", function() {
				$(".caseLAB").prop("checked", this.checked);
			});
			$(".caseLAB").on("click", function() {
				if ($(".caseLAB").length == $(".caseLAB:checked").length) {
					$("#selectallLAB").prop("checked", true);
				} else {
					$("#selectallLAB").prop("checked", false);
				}
			});

			$("#selectallGIN").on("click", function() {
				$(".caseGIN").prop("checked", this.checked);
			});
			$(".caseGIN").on("click", function() {
				if ($(".caseGIN").length == $(".caseGIN:checked").length) {
					$("#selectallGIN").prop("checked", true);
				} else {
					$("#selectallGIN").prop("checked", false);
				}
			});


			$("#formAreas").submit(function(e) {
				e.preventDefault();
				var data = $("#formAreas").serializeArray();
				data.push({
					name: 'flag',
					value: 'areas'
				})
				$.ajax({
						url: 'doEditaInsumo.php',
						type: 'post',
						dataType: 'json',
						data: data
					})

					.always(function() {
						alert("Datos Guardados.");
						window.location.href = window.location.href;
					})

			});

			$("#formAM").submit(function(e) {
				e.preventDefault();
				var data = $("#formAM").serializeArray();
				data.push({
					name: 'flag',
					value: 'am'
				})
				$.ajax({
						url: 'doEditaInsumo.php',
						type: 'post',
						dataType: 'json',
						data: data
					})

					.always(function() {
						alert("Datos Guardados.");
						window.location.href = window.location.href;
					})

			});


			$("#formOP").submit(function(e) {
				e.preventDefault();
				var data = $("#formOP").serializeArray();
				data.push({
					name: 'flag',
					value: 'op'
				})
				$.ajax({
						url: 'doEditaInsumo.php',
						type: 'post',
						dataType: 'json',
						data: data
					})
					.success(function() {
						console.log("exito");
						//alert.write("Todo en orden")
					})
					.fail(function() {
						console.log("ALGUN ERROR");
					})
					.always(function() {
						console.log("Proceso terminado");
					});
			});

			$("#FORMDEN").submit(function(e) {
				e.preventDefault();
				var data = $("#FORMDEN").serializeArray();
				data.push({
					name: 'flag',
					value: 'den'
				})
				$.ajax({
						url: 'doEditaInsumo.php',
						type: 'post',
						dataType: 'json',
						data: data
					})
					.success(function() {
						console.log("exito");
						//alert.write("Todo en orden")
					})
					.fail(function() {
						console.log("ALGUN ERROR");
					})
					.always(function() {
						console.log("Proceso terminado");
					});
			});

			$("#FORMLAB").submit(function(e) {
				e.preventDefault();
				var data = $("#FORMLAB").serializeArray();
				data.push({
					name: 'flag',
					value: 'lab'
				})
				$.ajax({
						url: 'doEditaInsumo.php',
						type: 'post',
						dataType: 'json',
						data: data
					})
					.success(function() {
						console.log("exito");
						//alert.write("Todo en orden")
					})
					.fail(function() {
						console.log("ALGUN ERROR");
					})
					.always(function() {
						console.log("Proceso terminado");
					});
			});


			$("#FORMGIN").submit(function(e) {
				e.preventDefault();
				var data = $("#FORMGIN").serializeArray();
				data.push({
					name: 'flag',
					value: 'gin'
				})
				$.ajax({
						url: 'doEditaInsumo.php',
						type: 'post',
						dataType: 'json',
						data: data
					})
					.success(function() {
						console.log("exito");
						//alert.write("Todo en orden")
					})
					.fail(function() {
						console.log("ALGUN ERROR");
					})
					.always(function() {
						console.log("Proceso terminado");
					});
			});

		}); //END OF READY FUNCTION
		
		function menuAMS() {
			$("#AMFORM").show();
		};

		function menuAMH() {
			$("#AMFORM").hide();
		};

		//OPTICA
		function menuOPS() {
			$("#OPFORM").show();
		};

		function menuOPH() {
			$("#OPFORM").hide();
		};


		//DENTAL
		function menuDENS() {
			$("#DENFORM").show();
		};

		function menuDENH() {
			$("#DENFORM").hide();
		};
		//LABORATORIO
		function menuLABS() {
			$("#LABFORM").show();
		};

		function menuLABH() {
			$("#LABFORM").hide();
		};
		//GINE
		function menuGINS() {
			$("#GINFORM").show();
		};

		function menuGINH() {
			$("#GINFORM").hide();
		};

		function menuareasS() {
			$("#areasmenu").show();
		}

		function menuareasH() {
			$("#areasmenu").hide();
		}
	</script>

</body>


</html>