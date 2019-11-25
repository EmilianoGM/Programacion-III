<?php
class Venta
{
    public $id;
    public $id_usuario;
    public $id_media;
    public $cantidad;
    
    public function __construct($id = null, $id_usuario = 0, $id_media = 0, $cantidad = 0)
    {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->id_media = $id_media;
        $this->cantidad = $cantidad;
    }
    /*-------------------FUNCIONES BASE DE DATOS-------------------*/
    public function AgregarDB(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        
            $consulta = $objetoPDO->prepare("INSERT INTO ventas(id_usuario, id_media, cantidad)" .
            "VALUES (:id_usuario,:id_media,:cantidad)");
            $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $consulta->bindValue(':id_media', $this->id_media, PDO::PARAM_INT);
            $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);

            $retorno = $consulta->execute();
            $objetoPDO = null;

        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function TraerDB(){
        $objetoPDO;
        $usuarios = array();
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        } catch(PDOException $error){
            return $error;
        }
        $consulta = $objetoPDO->prepare("SELECT * FROM ventas");
        //$consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Venta");
        return $usuarios;
    }

    public static function ExisteDBPorID($idABuscar){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("SELECT * FROM ventas WHERE id = :id");
            $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetch();
            $retorno = !(empty($resultado));
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function ExisteDB($idABuscar_Usuario, $idABuscar_Media){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("SELECT * FROM ventas WHERE id_usuario = :id_usuario AND id_media = :id_media");
            $consulta->bindValue(':id_usuario', $idABuscar_Media, PDO::PARAM_INT);
            $consulta->bindValue(':id_media', $idABuscar_Usuario, PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetch();
            echo "<br><br>";
            var_dump($resultado);
            $retorno = !(empty($resultado));
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function EliminarDB($idABuscar_Usuario, $idABuscar_Media){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");                      
            $consulta = $objetoPDO->prepare("DELETE FROM ventas WHERE id_usuario = :id_usuario AND id_media = :id_media");
            $consulta->bindValue(':id_usuario', $idABuscar_Usuario, PDO::PARAM_INT);
            $consulta->bindValue(':id_media', $idABuscar_Media, PDO::PARAM_INT);
            $consulta->execute();
            $count = $consulta->rowCount();
            if($count != '0'){
                $retorno = true;
            }
            $objetoPDO = null;
        } catch(PDOException $error){
            var_dump($error);
            $retorno = false;
        }
        return $retorno;
    }

    public function ModificarDB($idABuscar){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("UPDATE ventas SET cantidad = :cantidad WHERE id = :id");
            $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
            $consulta->execute();
            $count = $consulta->rowCount();
            if($count != '0'){
                $retorno = true;
            }
            $objetoPDO = null;
        } catch(PDOException $error){
            var_dump($error);
            return false;
        }

        return $retorno;
    }
    /*-------------------FUNCIONES PARA API-------------------*/ 
    public static function AltaVenta($request, $response, $args)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo al agregar";
        $objResponse = $response->withJson($objRetorno, 504);

        $datos = $request->getParsedBody();
        $datosJSON = json_decode($datos['venta']);
        $venta = new Venta(null, $datosJSON->id_usuario, $datosJSON->id_media, $datosJSON->cantidad);

        if($venta->AgregarDB()){
            $objRetorno->Exito = true;
            $objRetorno->Mensaje = "Agregado";
            $objResponse = $response->withJson($objRetorno, 200);
        }

        return $objRetorno; 
    }

    public static function ListadoVentas($request, $response, $args){
        $objRetorno = new stdClass();
        $objRetorno->Exito = true;
        $objRetorno->Mensaje = "Listado";
        $objRetorno->Datos = Venta::TraerDB();
        //CAMBIAR A SOLO LISTADO JSON
        return $response->withJson($objRetorno, 200); 
    }

    public static function EliminarVenta($request, $response, $args)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo al eliminar";
        
        $datos = $request->getParsedBody();
        $id_usuario = (int)$datos['id_usuario'];
        $id_media = (int)$datos['id_media'];
        if(Venta::ExisteDB($id_usuario, $id_media)){
            if(Venta::EliminarDB($id_usuario, $id_media)){
                $objRetorno->Exito = true;
                $objRetorno->Mensaje = "Venta eliminada";
            }
        } else{
            $objRetorno->Mensaje = "Id no encontrado";
        }
        return $response->withJson($objRetorno, 200); 
    }

    public static function ModificarVenta($request, $response, $args)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo al modificar";
        
        $datos = $request->getParsedBody();
        $id_venta = (int)$datos['id_venta'];
        $cantidad = (int)$datos['cantidad'];
        if(Venta::ExisteDBPorID($id_venta)){
            $venta = new Venta(null, 0, 0, $cantidad);
            if($venta->ModificarDB($id_venta)){
                $objRetorno->Exito = true;
                $objRetorno->Mensaje = "Modificado";
            }
        } else{
            $objRetorno->Mensaje = "Venta no encontrada";
        }

        return $response->withJson($objRetorno, 200); 
    }
}