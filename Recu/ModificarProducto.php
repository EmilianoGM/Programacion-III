<?php
require_once("./clases/Producto.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$id = isset($_POST["id"]) ? $_POST["id"] : null;
$codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : null;
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null;

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

if($id != null && $codigoBarra != null && $descripcion != null && $precio != null && $flag){
    $destino = "./productosModificados/" .$id. "." . $descripcion . ".modificado." . date("His") . ".jpg";
    $producto = new Producto($codigoBarra, $descripcion, $precio, $destino);
    if($producto->Modificar($id)){
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