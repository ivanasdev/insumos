<?php
require("../../configuracion.php");
$ruta2index = "../../../../";
require($ruta2index.'dbConexion.php');

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>




<?php /*?><link rel="stylesheet" href="<?=$ruta2index?>bionline/securitylayer/styles/styleTrasnparentBody.css" type="text/css">
<link href="<?=$ruta2index?>bionline/securitylayer/styles/style_botones.css" rel="stylesheet" type="text/css"><?php */?>

<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/jquery-1.11.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/media/css/jquery.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/pdf/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/pdf/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/pdf/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/buttons.html5.min.js"></script>

<script type="text/javascript" charset="utf8" src="<?=$ruta2index?>utils/datatables/DataTables-1.10.13/extensions/Buttons/js/buttons.print.min.js"></script>

<link href='http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css' rel='stylesheet'/>




<script type="text/javascript">



///////////////////////////////////////////////////////////////////////////////////////////////////////
function generaReporte(){
	
	var idSucursal = $("#idSucursal").val();
	
	$.ajax({
		url : "ajaxListaServicios.php",
		dataType : "html",
		type : "GET",
		data : {
			'idSucursal': idSucursal
		},
		beforeSend: function(){
			$("#contenedorDatatable").html('Cargando, por favor espere... <img src="<?=$ruta2index?>bionline/securitylayer/images/cargando.gif" border="0"/>');
		},
		success : function(data) {  															
			$("#contenedorDatatable").html(data);
			crearDatatable('#example');		
		},
		error: function (error) {
           $("#contenedorDatatable").html('Ocurrio un error');
        }
	});
	
	
}


function crearDatatable(elemento){

	// DataTable
    var table = $(elemento).DataTable(
	{		
		"aaSorting": [], 
		"bProcessing": true,
		dom: 'lBfrtip',
		"oLanguage": { "sUrl": "http://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"	},
		"buttons": [ 			
			{	extend: 'print', text: '<i class="fa fa-file-text-o"></i> IMPRIMIR', className: 'blue'	},
			{	extend: 'copy',	text: '<i class="fa fa-file-text-o"></i> COPIAR', className: 'orange'	},
			{	extend: 'excel',text: '<i class="fa fa-file-excel-o"></i> EXCEL',	className: 'green',	title:'LISTADO DE SERVICIOS'	},
			{	extend: 'pdf',	text: '<i class="fa fa-file-pdf-o"></i> PDF', className: 'red', title:'LISTADO DE SERVICIOS',	
				message: "Reporte:", orientation: 'landscape',	pageSize: 'LEGAL'
			},
			{	text: '<span class="fa fa-repeat"></span> ALTA DE SERVICIO',
				action: function ( e, dt, node, config ) {
				//alert('Hace Algo');
				location.href = "altaServicio.php";
			},
			className: 'green'	
			}
		],
		"initComplete": function(settings, json) {
			creaMotorBusqueda(table,elemento);
		}
	});
	
}

function creaMotorBusqueda(table,elemento){

	$(elemento).removeClass('display').addClass('table table-striped table-bordered');	
	
	 // Setup - add a text input to each footer cell
    $(elemento+' tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Busca por '+title+'" />' );
    } );
 
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );		
	
}


$(document).ready( function () {

	generaReporte();
	
});

</script>

<style type="text/css">

a.dt-button.red {	color: red;	}
a.dt-button.orange {	color: orange;	}
a.dt-button.green {	color: green;	}
a.dt-button.blue {	color: blue;	}


.topDiv{
	min-height:10px;
}

#espaciadoTitulo{
	min-height:100px;
	height:100px;
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

body{ 
	color: #333333; 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 7.5pt; 
	/*background:url(images/content_bg.png);*/
}      





</style> 
		


</head>

<body>

<div class="topDiv"></div>

<div id="contenido">

<table>
<tr>
    
    <td><img src="<?=$ruta2index?>bionline/securitylayer/images/statistics.gif" width="48" height="48"></td>
    <td><strong>ADMINISTRADOR DE SERVICIOS</strong></td>
    
</tr>
</table>


<div id="contenedorDatatable"></div>

</div>




</body>
</html>
