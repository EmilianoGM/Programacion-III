<?php
class Ufologo
{
    private $pais;
    private $legajo;
    private $clave;
    
    public function __construct($nuevoPais = "", $nuevoLegajo = "", $nuevaClave = ""){
        $this->pais = $nuevoPais;
        $this->legajo = $nuevoLegajo;
        $this->clave = $nuevaClave;      
    }

    public function ToJson(){
        $retorno = '{"pais":"'. $this->pais . '","legajo":"'. $this->legajo .'","clave":"'. $this->clave .'"}';
        return $retorno;
    }

    public function GuardarEnArchivo(){
        $objRetorno = new stdClass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "Error en la escritura";
        $destino = "./archivos";
        $stringEscritura = "";
        if(file_exists($destino)){
            $destino .= "/ufologos.json";
            if(!file_exists($destino)){
                $stringEscritura .= "[";
            } else {
                $archivo = fopen($destino, "r");
                while(!feof($archivo)){
                    $stringEscritura .= fgets($archivo);
                }
                fclose($archivo);
            }
            $archivo = fopen($destino, "w");
            $stringEscritura = str_replace("]", ",", $stringEscritura);
            $stringEscritura .= $this->ToJson();
            $stringEscritura .= "]\r\n";
            $cantidad = fwrite($archivo, $stringEscritura);
            if($cantidad > 0){
                $objRetorno->exito = true;
                $objRetorno->mensaje = "Archivo escrito";
            }
            fclose($archivo);
        }   
        return json_encode($objRetorno);
    }

    public static function TraerTodos(){
        $destino = "./archivos/ufologos.json";
        $linea = "";
        $ufologos = array();
        if(file_exists($destino)){
            $archivo = fopen($destino, "r");
            while(!feof($archivo)){
                $linea .= fgets($archivo);
            }
            if(!empty($linea)){
                $listaUfologosJSON = json_decode($linea);
                foreach ($listaUfologosJSON as $ufologoJSON) {
                    $nuevoUfologo = new Ufologo($ufologoJSON->pais, $ufologoJSON->legajo, $ufologoJSON->clave);
                    $ufologos[] = $nuevoUfologo;
                }
            }
        }
        return $ufologos;
    }

    public static function VerificarExistencia($ufologoAVerificar){
        $objRetorno = new stdClass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "Error al verificar";
        $listaUfologos = Ufologo::TraerTodos();
        if(!empty($listaUfologos)){
            $objRetorno->mensaje = "No se encontro al ufologo";
            foreach ($listaUfologos as $ufologo) {
                if($ufologo->legajo == $ufologoAVerificar->legajo && $ufologo->clave == $ufologoAVerificar->clave){
                    $objRetorno->exito = true;
                    $objRetorno->mensaje = "Ufologo encontrado";
                    break;
                }
            }
        }
        return json_encode($objRetorno);
    }
}

?>