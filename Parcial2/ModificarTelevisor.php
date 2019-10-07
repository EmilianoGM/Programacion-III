<?php
require_once("./clases/Televisor.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : null;

if($tipo != null && $precio != null && $paisOrigen != null){
    $televisor = new Televisor();
    var_dump($televisor->Modificar($tipo,$precio,$paisOrigen));/*
    if($televisor->Modificar($tipo,$precio,$paisOrigen)){
        $objRetorno->Exito = true;
        $objRetorno->Mensaje = "Correcto";
    } else{
        $objRetorno->Mensaje = "Fallo modificar";
    }*/
}
var_dump($objRetorno);
?>