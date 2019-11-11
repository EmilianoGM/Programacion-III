<?php
require_once("./clases/Producto.php");

$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$codigoBarra = isset($_GET["codigoBarra"]) ? $_GET["codigoBarra"] : null;
$codigoBarraPost = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : null;

if($codigoBarra != null || $codigoBarraPost != null){
    try{
        $objetoPDO = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");       
        $consulta = $objetoPDO->prepare("SELECT codigo_barra AS codigoBarra,descripcion, precio, foto AS pathFoto FROM productos WHERE codigo_barra = :codigoBarra");
        if($codigoBarra != null){
            $consulta->bindValue(':codigoBarra', $codigoBarra, PDO::PARAM_INT);
        } else {
            $consulta->bindValue(':codigoBarra', $codigoBarraPost, PDO::PARAM_INT);
        }
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Producto');
        $producto = $consulta->fetch();
        $resultado = !(empty($producto));
        if($resultado){
            if($codigoBarra != null){
                $objRetorno->Exito = true;
                $objRetorno->Mensaje = "El producto esta en la base de datos";
            } else if(isset($_POST) && isset($_POST["accion"]) && $_POST["accion"] == "borrar"){
                if($producto->Eliminar()){
                    header('Location: ./Listado.php');
                } else{
                    $objRetorno->Mensaje = "Fallo al eliminar";
                }
            }
        } else if (isset($_GET)){
            $objRetorno->Mensaje = "El producto NO esta en la base de datos";
        }
        $objetoPDO = null;
    } catch(PDOException $error){
        $objRetorno->Mensaje = "error objeto PDO";
    }
}

echo json_encode($objRetorno);

?>
