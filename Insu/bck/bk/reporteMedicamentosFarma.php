<?php
require("../../db.php");
 
/////////////////////////////////////// Obtiene Sucursales ////////////
$ruta2index = "../../../";
include($ruta2index."bionline/securitylayer/reportes/class.Catalogos.php");
$objCatalogos = new Catalogos();
////////////////////////////////////////////////////////////////////// 

session_start();
////////////////////////////// TRACKING ////////////////
include($ruta2index."class.Tracking.php");
$objTracking = new Tracking(1,3,"FARMACIA - Reporte Desplazamiento Farmacia");
///////////////////////////////////////////////////////	
 

$banderasuc=0;

if($_SESSION['id_Sucursal'])
{
	$selectSucursales = $objCatalogos->obtieneSucursalML($_SESSION['id_Sucursal']);
	$banderasuc=1;
}else{
	$selectSucursales = $objCatalogos->obtieneSucursalesML();  
}

$action= "exportXLS3NDesplazamientoFarma.php";
   
?>
<html>
<head>

<meta charset="utf-8">
<script src="<?=$ruta2index?>utils/autocomplete_ui_2020/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=$ruta2index?>utils/autocomplete_ui_2020/jquery-ui.css">
<script type="text/javascript" src="<?=$ruta2index?>utils/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?=$ruta2index?>utils/jquery-ui-1.11.0.custom/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=$ruta2index?>utils/jquery-ui-1.11.0.custom/jquery.ui.datepicker-es.js"></script> 
<link href="<?=$ruta2index?>utils/jquery-ui-1.11.0.custom/css/jquery_ui/redmond/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css">
<link href="<?=$ruta2index?>bionline/securitylayer/styles/botones.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
/////////////////////////////// Configura el Calendario


$(document).ready(function() {// Handler for .ready() called.

  $(".auto").keyup(function(){
	//if ($(this).val().length>5) {
		var x=$(this).data( "aux");
		aux($(this).val(),x);
	//}
  });	


  const fecha = new Date();
  var dia = fecha.getDate();    
  var mes = fecha.getMonth() + 1; 
  var año = fecha.getFullYear();

  if (dia < 10) {
    var dia = '0'+ dia;
    var mes = '0'+ (fecha.getMonth() + 1); 
    var IniciodelMes = año+'-'+mes+'-'+'0'+((dia-dia)+1);
  }
  else{
    var dia = dia;
    var mes = fecha.getMonth() + 1; 
    var IniciodelMes = año+'-'+mes+'-'+((dia-dia)+1);
  }
  var minDate = IniciodelMes;
  var fechaActual = año+'-'+mes+'-'+dia;
  var maxDate = fechaActual;

  $('#fechacita,#fechacita2').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth:false,
		changeYear:false,
        yearRange: '-0:0',
        minDate: -60,
        maxDate: maxDate
			});	
});	

function aux(aux,x){ 
			var session=$("#idsession_post").val();
			var auto=aux;

			$.ajax({
				//url:"../CEDSurtidoPedido/ListSucursaleAutocom.php",
				url:"../../../utils/autocomplete_ui_2020/Class.SucursaleAutocom.php",
				type:"POST",
				dataType:'JSON',
				data:{type:83,auto:auto},
				beforeSend:function(object){
				},
				success:function(response){
					if(response.flagerror==1){
						alertError(response.Message,'');
					}else{
					    $( function() {
						    $( ".auto" ).autocomplete({
						      source: response.tabla,
						      select: function( event, ui ) {
						      	if(x=='1'){
						      		$( "#namesuc" ).val( ui.item.label );
						        	$( "#idsucursal" ).val( ui.item.value );
						      	}else{
						      		$( "#namesucDes" ).val( ui.item.label );
						        	$( "#idsucursal" ).val( ui.item.value );
						      	}
						        return false;
						      }
    						})
					    });					
            }
          }   
			});
    }

</script>


<title><?= $instanciaECRM ?></title>
  <link rel="stylesheet" href="../styles/style.css" type="text/css">
</head>
<body leftmargin="0"  topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="<?=$action?>" name="Guion">
<table width="100" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#FFFFFF" valign="top" height="400">

<table border="0" cellpadding="5" cellspacing="0" width="750">
  <tr><td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td colspan="3"></td></tr><tr>
      <td width="8%"><img src="../images/statistics.gif" width="48" height="48"></td>
                        <td width="92%"><strong class="pageTitle">Reporte de ventas Farmacia 
                          por Fecha y sucursal</strong></td>
    </tr>
  </table></td></tr>
  <tr>
  <td valign="top" width="100%">
    <table width="48%" height="20" border="0" cellpadding="0" cellspacing="0">
      <tr><td><table width="700" border="0" cellpadding="5" cellspacing="1">
        <tr class="answerCellBG">
          <td width="20">Inicio
          <input name="tipo" type="hidden" id="tipo" value="<?=$_GET['id']?>"></td>
          <td width="246"> <input name="fechacita" type="text" id="fechacita" value="" readonly /></td>
        </tr>
        <tr class="answerCellBG">
          <td>Fin</td>
          <td><input name="fechacita2" type="text" id="fechacita2" value="" readonly /></td>
        </tr>
        <tr class="answerCellBG">
          <!--<td>&nbsp;</td>-->
         <!-- <td> -->
        <!-- Se imprime el select y se muestran todas las sucursales -->
         <!-- <select name="idsucursal">
          <?
		 /* if ($banderasuc==0) { 
		  ?> 
          <option value="99999">-- TODAS --</option>
		  <?
		   }
		  echo $selectSucursales;*/
		  ?>
          </select> -->
        <!------------------------------------------------------------>
       <tr>
					<td>Sucursal:</td>
					<td>
						<div class="">
							<input id="namesuc" name="namesuc" type="text" class="auto" data-aux="1"  autocomplete="off" style="width: 400px;">
							<input type="hidden" name="idsucursal" id="idsucursal" value="0">
						</div>
					</td>
				</tr>   
                
        </tr>
        <tr class="answerCellBG">
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Enviar" class="botonAzul"></td>
        </tr>
        <!--<tr class="answerCellBG">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>-->
        <!--<tr class="answerCellBG">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>-->
      </table></td>
    </tr>
    </table>

    <br>
    <!--REPORTES EXCEL  -->
    <div class="align-self-center">

    <a  href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2021/REPORTECOMPLETO2021.xlsx" style="margin-right: 20px;" >
    <img class="center"  src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE COMPLETO 2021</a>

    <a href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2022/ENERO2022.xlsx" style="margin-right: 20px; ">
    <img class="center" src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE ENERO 2022</a>

    <a href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2022/FEBRERO2022.xlsx" style="margin-right: 20px; margin-bottom: 20px;">
    <img class="center" src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE FEBRERO 2022</a>

    <a href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2022/MARZO2022.xlsx" style="margin-right: 15px; margin-bottom: 20px;">
    <img class="center" src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE MARZO 2022</a> 
		
	<a href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2022/mes_Abril.xlsx" style="margin-right: 15px; margin-bottom: 20px;">
    <img class="center" src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE ABRIL 2022</a>

    <a href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2022/mes_Mayo.xlsx" style="margin-right: 15px; margin-bottom: 20px;">
    <img class="center" src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE MAYO 2022</a>
	
	<a href="/bionline/securitylayer/reportes/xlsreportes/Farmacia/Reporte Desplazamiento Farmacia/2022/JUNIO2022.xlsx" style="margin-right: 15px; margin-bottom: 20px;">
    <img class="center" src="../images/logo_excel.gif" width="37" height="37" />
    REPORTE JUNIO 2022</a>
    </div> <br>

    <DIV id=Layer1 
style="Z-INDEX: 2; LEFT: 214px; VISIBILITY: hidden; WIDTH: 486px; POSITION: absolute; TOP: 77px; HEIGHT: 123px">
      <TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
        <TBODY>
         
          <TR>
            
            <TD vAlign=top width=12 background=../images/xc_center.gif><div align="left"><img src="../images/xc_left2.gif" width="24" height="23"></div></TD>
            <TD vAlign=top width=448 background=../images/xc_center.gif><div align="center">Reportes Estdisticos con graficos </div></TD>
            <TD vAlign=top width=26><img src="../images/xc_right.gif" width="24" height="23"></TD>
          </TR>
          <TR>
            <TD colSpan=4></TD>
          </TR>
        </TBODY>
      </TABLE>
      <div align="center"><img src="../images/charts.jpg" width="374" height="124">
        
          <table width="100%" border="0">
          <tr>
            <td background="../images/xc_center.gif"><div align="center"><br></div></td>
          </tr>
        </table>
      </div>
    </DIV>
    </td>
  </tr>
</table>
          
          <DIV id=Layer2 
style="Z-INDEX: 2; LEFT: 221px; VISIBILITY: hidden; WIDTH: 505px; POSITION: absolute; TOP: 86px; HEIGHT: 8px">
            <table width="100%" border="0">
              <tr>
                <td><TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
                  <TBODY>
                    <TR>
                      <TD vAlign=top width=12 background=../images/xc_center.gif><div align="left"><img src="../images/xc_left2.gif" width="24" height="23"></div></TD>
                      <TD vAlign=top width=448 background=../images/xc_center.gif><div align="center">Reportes Estadisticos con volcados a excel y word </div></TD>
                      <TD vAlign=top width=26><img src="../images/xc_right.gif" width="24" height="23"></TD>
                    </TR>
                    <TR>
                      <TD colSpan=4></TD>
                    </TR>
                  </TBODY>
                </TABLE>
                  <table width="100%" border="0">
                    <tr>
                      <td><table width="100%" border="0">
                          <tr>
                            <td><div align="center"><img src="../images/word.jpg" width="94" height="98"></div></td>
                            <td><div align="center"><img src="../images/excel.jpg" width="120" height="75"></div></td>
                          </tr>
                        </table>
                        <table width="100%" border="0">
                          <tr>
                            <td background="../images/xc_center.gif"><br></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </DIV></td>
          <!-- <td width="36" background="../images/f_int.jpg"><img src="../images/f_int.jpg" width="36" height="126"></td> -->
        </tr>
      </table></td>
  </tr>
</table>
<!-- <table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images/fotterint.jpg">
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="../images/f_int_new.jpg" height="32" width="800" alt=""></td>
        </tr>
      </table></td>
  </tr>
</table> -->

<br>
<br>
<br>
<table width="750" border="0">
  <tr>
    <td align="right"><span class="copyright"><?= $copyright ?></span></td>
  </tr>
</table></form>
</body>
</html>
