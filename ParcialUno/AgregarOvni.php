<?php
require_once("./clases/Ovni.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$velocidad = isset($_POST["velocidad"]) ? $_POST["velocidad"] : null;
$planetaOrigen = isset($_POST["planetaOrigen"]) ? $_POST["planetaOrigen"] : null;

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

if($tipo != null && $velocidad != null && $planetaOrigen != null && $flag){
    $ovni = new Ovni($tipo, $velocidad, $planetaOrigen, "");
    if($ovni->Existe()){
        $objRetorno->Mensaje = "Ovni ya existe";
    } else {
        $destino = "./ovnis/imagenes/" .$ovni->tipo. "." . $ovni->planetaOrigen . "." . date("His") . ".jpg";
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
            $ovni->pathFoto = $destino;
            if($ovni-> Agregar()){
                header('Location: ./Listado.php');
            } else{
                $objRetorno->Mensaje = "no agregado";
            }
        }
    }
}
echo json_encode($objRetorno);
?>