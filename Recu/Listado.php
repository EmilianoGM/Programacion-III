<?php
require_once("./clases/Producto.php");
if(isset($_GET)){
    $tabla = "<table border='1'>
                <tr><td>Codigo barra</td><td>Descripcion</td><td>Precio</td><td>Foto</td><td>Precio + IVA</td></tr>
    ";
    $productos = Producto::Traer();
    foreach ($productos as $nuevoProducto) {
        $tabla .= "<tr>
        <tr><td>". $nuevoProducto->codigoBarra. "</td>
        <td>". $nuevoProducto->descripcion ."</td>
        <td>".$nuevoProducto->precio."</td>
        <td><img src='". $nuevoProducto->pathFoto."' alt='Sin imagen' height='100' width='100'></td>
        <td>".$nuevoProducto->CalcularIVA()."</td>
        </tr>
        ";
    }
    $tabla .= "</table>";
    echo $tabla;
} else{
    echo "Error GET";
}
?>