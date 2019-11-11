<?php
require_once("./clases/Ovni.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$id = isset($_POST["id"]) ? $_POST["id"] : null;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$velocidad = isset($_POST["velocidad"]) ? $_POST["velocidad"] : null;
$planetaOrigen = isset($_POST["planetaOrigen"]) ? $_POST["planetaOrigen"] : null;

$flag = false;
if(isset($_FILES["archivo"])){
    $esImagen = getimagesize($_FILES["archivo"]["tmp_name"]); //confirma si es imagen
    if($esImagen !== FALSE) {
        $flag = true;
    } else{
        $objRetorno->Mensaje = "No es imagen";
    }
} else{
    $objRetorno->Mensaje = "NO hay imagen";
}

if($id != null && $tipo != null && $velocidad != null && $planetaOrigen != null && $flag){
    $destino = "./ovnisModificados/" .$tipo. "." . $planetaOrigen . ".modificado." . date("His") . ".jpg";
    $ovni = new Ovni($tipo, $velocidad, $planetaOrigen, $destino);
    if($ovni->Modificar($id)){
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
            header('Location: ./Listado.php');
        } else{
            $objRetorno->Mensaje = "Fallo al subir imagen";
        }
    } else{
        $objRetorno->Mensaje = "Fallo al modificar";
    }
} else {
    $objRetorno->Mensaje = "Informacion incompleta";
}
echo json_encode($objRetorno);
?>