<?php
require_once("./clases/Televisor.php");
if(isset($_GET)){
    $tabla = "<table border='1'>
                <tr><td>Tipo</td><td>Precio</td><td>Pais de origen</td><td>Foto</td><td>Precio con IVA</td></tr>
    ";
    $televisores = Televisor::Traer();
    //var_dump($televisores);
    
    foreach ($televisores as $televisor) {
        $tabla .= "<tr>
        <tr><td>". $televisor->tipo. "</td>
        <td>". $televisor->precio ."</td>
        <td>".$televisor->paisOrigen."</td>
        <td><img src='".$televisor->path."' alt='Sin imagen' height='100' width='100'></td>
        <td>".$televisor->CalcularIVA()."</td>
        </tr>
        ";
    }
    $tabla .= "</table>";
    echo $tabla;
} else{
    echo "Error GET";
}
?>