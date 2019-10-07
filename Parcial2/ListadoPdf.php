<?php
require_once("./clases/Televisor.php");

require_once __DIR__ . '/vendor/autoload.php';
header('content-type:application/pdf');


$tabla = "<table border='1'>
<tr><td>Tipo</td><td>Precio</td><td>Pais de origen</td><td>Foto</td><td>Precio con IVA</td></tr>
";
if(isset($_GET)){
   
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
}
$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);
$mpdf->SetHeader('{PAGENO}{nbpg}');
$mpdf->setFooter('{PAGENO}');
$mpdf->WriteHTML($tabla);
$mpdf->Output();
?>