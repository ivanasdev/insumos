<?php
$ruta2index = "../../../../";
require($ruta2index . 'dbConexion.php');

////////////////////////////// TRACKING ////////////////
include($ruta2index . "class.Tracking.php");
$objTracking = new Tracking(1, 6, "CATALOGOS - Insumos");
///////////////////////////////////////////////////////	
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>

	<script type="text/javascript" src="<?= $ruta2index ?>utils/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/media/css/jquery.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/media/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/css/buttons.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/pdf/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/pdf/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/pdf/vfs_fonts.js"></script>
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/buttons.html5.min.js"></script>
	<script type="text/javascript" charset="utf8" src="<?= $ruta2index ?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/buttons.print.min.js"></script>
	<link href='http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css' rel='stylesheet' />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


	<link href="<?= $ruta2index ?>utils/tinybox/style_tiny.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?= $ruta2index ?>utils/tinybox/tinybox.js"></script>




	<script type="text/javascript">
		/////////// TinyBox ///////////
		function abrirPop(ancho, alto, php) {
			TINY.box.show({
				iframe: php,
				boxid: 'frameless',
				width: ancho,
				height: alto,
				fixed: false,
				maskid: 'graymask',
				maskopacity: 40,
				closejs: function() {

					var refreshPagina = $('#refreshPagina').val();
					if (refreshPagina == 1) {
						location.reload(true);
					}

				}
			});
		}



		///////////////////////////////////////////////////////////////////////////////////////////////////////
		function generaReporte() {

			var idSucursal = $("#idSucursal").val();
			console.log("roa: "+ idSucursal)
			$.ajax({
				url: "ajaxTable.php",
				dataType: "html",
				type: "GET",
				data: {
					'idSucursal': idSucursal
				},
				beforeSend: function() {
					$("#contenedorDatatable").html(
						'Cargando, por favor espere... <img src="<?= $ruta2index ?>bionline/securitylayer/images/cargando.gif" border="0"/>'
					);
				},
				success: function(data) {
					$("#contenedorDatatable").html(data);
					crearDataTable('#example');
				},
				error: function(error) {
					$("#contenedorDatatable").html('Ocurrio un error');
				}
			});


		}


		function creaMotorBusqueda(table, elemento) {

			$(elemento).removeClass('display').addClass('table table-striped table-bordered');

			// Setup - add a text input to each footer cell
			$(elemento + ' tfoot th').each(function() {
				var title = $(this).text();
				$(this).html('<input type="text" placeholder="Busca por ' + title + '" />');
			});


			// Apply the search
			table.columns().every(function() {
				var that = this;

				$('input', this.footer()).on('keyup change', function() {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});

		}

		function crearDataTable(elemento) {

			// DataTable
			var table = $(elemento).DataTable({
				"aaSorting": [],
				"bProcessing": true,
				dom: 'lBfrtip',
				"oLanguage": {
					"sUrl": "http://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				"buttons": [{
						extend: 'print',
						text: '<i class="fa fa-file-text-o"></i> IMPRIMIR',
						className: 'blue',
						title: 'CATALOGO INSUMOS'
					},
					{
						extend: 'copy',
						text: '<i class="fa fa-file-text-o"></i> COPIAR',
						className: 'orange'
					},
					{
						extend: 'excel',
						text: '<i class="fa fa-file-excel-o"></i> EXCEL',
						className: 'green',
						title: 'CATALOGO INSUMOS'
					},
					{
						extend: 'pdf',
						text: '<i class="fa fa-file-pdf-o"></i> PDF',
						className: 'red',
						title: 'CATALOGO INSUMOS',
						message: "Reporte:",
						orientation: 'portrait',
						pageSize: 'LEGAL'
					},
					{
						text: '<span class="fa fa-arrow-circle-up"></span> ALTA DE INSUMO',
						action: function(e, dt, node, config) {
							console.log('Hace Algo');
							location.href = "javascript:abrirPop('500','250','altaInsumo.php')";
						},
						className: 'green'
					}
				],
				"initComplete": function(settings, json) {
					creaMotorBusqueda(table, elemento);
				}
			});

		}



		$(document).ready(function() {

			generaReporte();

		});
	</script>

	<style type="text/css">
		a.dt-button {
			font-size: 10px;
			font-family: Verdana, Geneva, sans-serif;
		}

		a.dt-button.red {
			color: red;
		}

		a.dt-button.orange {
			color: orange;
		}

		a.dt-button.green {
			color: green;
		}

		a.dt-button.blue {
			color: blue;
		}

		body {
			color: #333333;
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 7.5pt;
			background: url(content_bg.png);
		}
	</style>


</head>

<body>

	<div class="topDiv"></div>
	<input type="hidden" name="refreshPagina" id="refreshPagina" size="20" value="0" />

	<div id="contenido">

		<table>
			<tr>

				<td><img src="<?= $ruta2index ?>bionline/securitylayer/images/statistics.gif" width="48" height="48"></td>
				<td><strong>CATALOGO DE INSUMOS</strong></td>

			</tr>
		</table>


		<div id="contenedorDatatable"></div>

	</div>


	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

</body>

</html>