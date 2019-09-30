<?php
require_once __DIR__ . '/vendor/autoload.php';
header('content-type:application/pdf');

$connectionPDO = new PDO("mysql:host=localhost;dbname=mercado;charset=utf8", "root", "");
$sentencia = $connectionPDO->prepare("SELECT * FROM usuarios");
$sentencia->execute();
$tabla = "<table border='1'>
            <tr>
                <td>Id</td><td>Nombre</td><td>Apellido</td><td>Clave</td><td>Perfil</td><td>Estado</td><td>Correo</td>
            </tr>";
while($fila = $sentencia->fetch()){
    $tabla .= "<tr><td>" . $fila["id"] . "</td><td>" . $fila["nombre"] .
    "</td><td>" . $fila["apellido"] . "</td><td>" . $fila["clave"] . "</td><td>" .
    $fila["perfil"] . "</td><td>" .  $fila["estado"] . "</td><td>" . $fila["correo"] . "</td></tr>";
}
$tabla .= "</table>";
//echo $tabla;

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<h1>Listado de usuarios</h1>');
$mpdf->WriteHTML("<br>");
$mpdf->WriteHTML($tabla);
$mpdf->Output();
?>