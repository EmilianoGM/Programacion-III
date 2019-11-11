<?php
require_once("./clases/Producto.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$producto = isset($_POST["producto"]) ? $_POST["producto"] : null;

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

if($producto != null && $flag){
    $productoJSON = json_decode($producto);
    $nuevoProducto = new Producto($productoJSON->codigoBarra, $productoJSON->descripcion, $productoJSON->precio, "");
    if($nuevoProducto->Existe()){
        $objRetorno->Mensaje = "Producto ya existe";
    } else {
        $destino = "./productos/imagenes/" .$nuevoProducto->codigoBarra. "." . $nuevoProducto->descripcion . "." . date("His") . ".jpg";
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
            $nuevoProducto->pathFoto = $destino;
            if($nuevoProducto-> Agregar()){
                header('Location: ./Listado.php');
            } else{
                $objRetorno->Mensaje = "no agregado";
            }
        }
    }
}
echo json_encode($objRetorno);
?>