<?php
require ".\Clases\Producto.php";

    $option = "MOSTRAR";

    switch ($option) {
        case 'ALTA':
            //$producto = new Producto("Bic", "123456789");
            $producto = new Producto($_POST["name"], $_POST["cod_barra"]);
            if($producto::Guardar($producto)){
                echo "Saved Suscesfully";
            }else{
                echo "Error Saving File";
            }
            break;
        case 'MOSTRAR':
            $producto = new Producto("Bic", "123456789");
            $producto->LoadProducts();
            break;
        
        default:

            break;
    }

?>