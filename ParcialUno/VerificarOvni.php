<?php
require_once("./clases/Ovni.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$ovni = isset($_POST["ovni"]) ? $_POST["ovni"] : null;

if($ovni != null){
    $ovniJSON = json_decode($ovni);
    $nuevoOvni = new Ovni($ovniJSON->tipo, $ovniJSON->velocidad, $ovniJSON->planetaOrigen,"");
    $objRetorno->Exito = $nuevoOvni->Existe(); 
    if($objRetorno->Exito){
        $objRetorno->Mensaje = "Encontrado";
    } else{
        $objRetorno->Mensaje = "No encontrado";
    }
}
echo json_encode($objRetorno);
?>