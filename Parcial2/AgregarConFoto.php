<?php
require_once("./clases/Televisor.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;

$flag = false;
if(isset($_FILES["archivo"])){
    $esImagen = getimagesize($_FILES["archivo"]["tmp_name"]); //confirma si es imagen
    if($esImagen !== FALSE) {
        $flag = true;
    } else{
        echo "no es imagen";
    }
} else{
    echo "no hay imagen";
}

if($tipo != null && $precio != null && $paisOrigen != null && $flag){
    $destino = "./fotos/" . date("Ymd_His") . ".jpg";
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
        $televisor = new Televisor($tipo, $precio, $paisOrigen, $destino);
        if($televisor-> Agregar()){
            echo "Agregado";
        } else{
            echo "Fallo agregar";
        }
    }
} else{
    echo "error en flag";
}
echo "que mierda";