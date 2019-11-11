<?php
require_once("./clases/Producto.php");
$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$producto = isset($_POST["producto"]) ? $_POST["producto"] : null;

if($producto != null){
    $productoJSON = json_decode($producto);
    $nuevoProducto = new Producto($productoJSON->codigoBarra, $productoJSON->descripcion, $productoJSON->precio,"");
    $objRetorno->Exito = $nuevoProducto->Existe(); 
    if($objRetorno->Exito){
        $objRetorno->Mensaje = "Encontrado";
    } else{
        $objRetorno->Mensaje = "No encontrado";
    }
}
echo json_encode($objRetorno);
?>