<?php
require_once(__DIR__ . "/IParte2.php");

class Producto implements IParte2{
    public $codigoBarra;
    public $descripcion;
    public $precio;
    public $pathFoto;

    public function __construct($nuevoCodigoBarra = "",$nuevaDescripcion = "", $nuevoPrecio = "" , $nuevoPath = "")
    {
        $this->codigoBarra = $nuevoCodigoBarra;
        $this->descripcion = $nuevaDescripcion;
        $this->precio = $nuevoPrecio;
        $this->pathFoto = $nuevoPath;
    }

    public function ToJson(){
        return json_encode($this);
    }

    public function Agregar(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
        
            $consulta = $objetoPDO->prepare("INSERT INTO productos(codigo_barra, descripcion, precio, foto)" .
            "VALUES (:codigoBarra,:descripcion,:precio,:pathFoto)");
            $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function Traer(){
        $objetoPDO;
        $productosArray = array();
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
        } catch(PDOException $error){
            return $error;
        }
        $consulta = $objetoPDO->prepare("SELECT codigo_barra AS codigoBarra,descripcion, precio, foto AS pathFoto FROM productos");
        $consulta->execute();
        $productosArray = $consulta->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Producto");
        return $productosArray;
    }
    
    public function CalcularIVA(){
        return $this->precio + ($this->precio * 0.21);
    }

    public function Existe(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("SELECT * FROM productos WHERE codigo_barra = :codigoBarra AND descripcion = :descripcion AND precio = :precio");
            $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetch();
            $retorno = !(empty($resultado));
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public function Modificar($idABuscar){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("UPDATE productos SET codigo_barra = :codigoBarra, descripcion = :descripcion, precio = :precio, foto = :pathFoto WHERE id = :id");
            $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
            $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
            $consulta->execute();
            $count = $consulta->rowCount();
            if($count != '0'){
                $retorno = true;
            }
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public function Eliminar(){
        $retorno = false;
        if($this->Existe()){
            try{
                $objetoPDO = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");                      
                $consulta = $objetoPDO->prepare("DELETE FROM productos WHERE codigo_barra = :codigoBarra AND descripcion = :descripcion AND precio = :precio AND foto = :pathFoto");
                $consulta->bindValue(':codigoBarra', $this->codigoBarra, PDO::PARAM_INT);
                $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
                $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
                $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
                $consulta->execute();
                $count = $consulta->rowCount();
                if($count != '0'){
                    $retorno = true;
                }
                $objetoPDO = null;
            } catch(PDOException $error){
                return false;
            }
        }
        return $retorno;
    }
/*
    public function GuardarEnArchivo($id){
        $retorno = false;
        $destino = "./archivos";
        $stringEscritura = "";
        if(file_exists($destino)){
            $pathBorrada = $id . "." . $this->codigoBarra . ".borrado." . date("His") . ".jpg";
            if(rename($this->pathFoto, "./ovnisBorrados/" . $pathBorrada)){
                $destino .= "/ovnis_borrados.txt";
                $archivo = fopen($destino, "a");
                $stringEscritura .= "Tipo: " . $this->codigoBarra . " - Velocidad: " . $this->descripcion . " - Planeta: " .
                $this->precio . " - PathFoto : ./ovnisBorrados/" . $pathBorrada;
                $stringEscritura .= "\r\n";
                $cantidad = fwrite($archivo, $stringEscritura);
                if($cantidad > 0){
                    $retorno = true;
                }
                fclose($archivo);
            }else{
                echo("Error rename");
            }
        }
        return $retorno;
    }

    public static function MostrarBorrados(){
        $destino = "./archivos/ovnis_borrados.txt";
        $retorno = "no hay productos borrados";  
        if(file_exists($destino)){
            $archivo = fopen($destino, "r");
            $retorno = fread($archivo, filesize($destino));
        }
        return $retorno;
    }*/
}
?>