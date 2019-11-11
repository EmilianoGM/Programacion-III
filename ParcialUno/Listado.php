<?php
require_once("./clases/Ovni.php");
if(isset($_GET)){
    $tabla = "<table border='1'>
                <tr><td>Tipo</td><td>Velocidad</td><td>Planeta de origen</td><td>Foto</td><td>Velocidad WARP</td></tr>
    ";
    $ovnis = Ovni::Traer();
    foreach ($ovnis as $nuevoOvni) {
        $tabla .= "<tr>
        <tr><td>". $nuevoOvni->tipo. "</td>
        <td>". $nuevoOvni->velocidad ."</td>
        <td>".$nuevoOvni->planetaOrigen."</td>
        <td><img src='". $nuevoOvni->pathFoto."' alt='Sin imagen' height='100' width='100'></td>
        <td>".$nuevoOvni->ActivarVelocidadWarp()."</td>
        </tr>
        ";
    }
    $tabla .= "</table>";
    echo $tabla;
} else{
    echo "Error GET";
}
?>