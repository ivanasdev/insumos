<?php

if(isset($_POST['id_Sucursal'])){
    $idsucursal=$_POST['idSucursal'] ;
    $boxes=$_POST['chk'];
    foreach($boxes as $row => $value){
        echo $value;
    }
    
    
    echo $boxes."<br>";
    echo $cadenaInsumos;





}
else{
    echo "<script> alert('Sucursal Invalida')</script>";
}



?>

