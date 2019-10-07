<?php
require_once("./clases/Televisor.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;

if($tipo != null && $precio != null && $paisOrigen != null){
    $televisor = new Televisor($tipo, $precio, $paisOrigen);
    if($televisor-> Agregar()){
        $objRetorno->Exito = true;
        $objRetorno->Mensaje = "Correcto";
    } else{
        $objRetorno->Mensaje = "Fallo agregar";
    }
}
var_dump($objRetorno);
?>