<?php
require_once("./clases/Ufologo.php");
$objRetorno = new stdClass();
$objRetorno->exito = false;
$objRetorno->mensaje = "Fallo POST";
if(isset($_POST["legajo"]) && isset($_POST["clave"])){
    $legajo = $_POST["legajo"];
    $clave = $_POST["clave"];
    $nuevoUfologo = new Ufologo("", $legajo, $clave);
    $respuesta = Ufologo::VerificarExistencia($nuevoUfologo);
    $objRetorno = json_decode($respuesta);
    if($objRetorno->exito == true){
        $datos =  "" . date("H:i:s") . " - " . $objRetorno->mensaje;
        setcookie($legajo, $datos);
        header('Location: ./ListadoUfologos.php');
    }
}
echo json_encode($objRetorno);
?>