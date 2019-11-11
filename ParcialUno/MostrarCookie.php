<?php
require_once("./clases/Ufologo.php");
$objRetorno = new stdClass();
$objRetorno->exito = false;
$objRetorno->mensaje = "Fallo GET";
if(isset($_GET["legajo"])){
    $objRetorno->mensaje = "Fallo Legajo";
    $legajo = $_GET["legajo"];
    $legajoJSON = json_decode($legajo);
    if(isset($_COOKIE[$legajoJSON->legajo])){
        $msj = $_COOKIE[$legajoJSON->legajo];
        $objRetorno->mensaje = $msj;
        $objRetorno->exito = true;
    }
}
echo json_encode($objRetorno);
?>