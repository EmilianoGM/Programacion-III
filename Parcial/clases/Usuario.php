<?php
class Usuario
{
    private $email;
    private $clave;
    
    public function __construct($nuevoEmail = "", $nuevaClave = ""){
        $this->email = $nuevoEmail;
        $this->clave = $nuevaClave;
    }

    public function ToJson(){
        $retorno = '{"email":"'. $this->email .'","clave":"'. $this->clave .'"}';
        //$retorno = json_encode($this);
        return $retorno;
    }

    public function GuardarEnArchivo(){
        $objRetorno = new stdClass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "Error en la escritura";
        $destino = "./archivos";
        $stringEscritura = "";
        if(file_exists($destino)){
            $destino .= "/usuarios.json";
            if(!file_exists($destino)){
                $stringEscritura .= "[";
            } else {
                $stringEscritura .= ",";
                Usuario::EliminarCaracteres($destino);
            }
            $archivo = fopen($destino, "a");
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
        $destino = "./archivos/usuarios.json";
        $linea = "";
        $usuarios = array();
        if(file_exists($destino)){
            $archivo = fopen($destino, "r");
            while(!feof($archivo)){
                $linea .= fgets($archivo);
            }
            if(!empty($linea)){
                $listaUsuariosJSON = json_decode($linea);
                foreach ($listaUsuariosJSON as $usuarioJSON) {
                    $nuevoUsuario = new Usuario($usuarioJSON->email, $usuarioJSON->clave);
                    $usuarios[] = $nuevoUsuario;
                }
            }
        }
        return $usuarios;
        //return $listaUsuariosJSON = json_decode($linea);
    }
    /*
    public static function TraerTodos2()
    {
        $usuarios = array();
        $objetoPDO;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        } catch(PDOException $error){
            return false;
        }
        $sentencia = $objetoPDO->prepare('SELECT * FROM usuarios');
        while($fila = $sentencia->fetch()){
            $usuario = new Usuario($fila["email"], $fila["clave"]);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    */

    public static function VerificarExistencia($usuarioAVerificar){
        $retorno = false;
        $listaUsuarios = Usuario::TraerTodos();
        if(!empty($listaUsuarios)){
            foreach ($listaUsuarios as $user) {
                if($user->email == $usuarioAVerificar->email && $user->clave == $usuarioAVerificar->clave){
                    $retorno = true;
                    break;
                }
            }
        }
        return $retorno;
    }

    public static function EliminarCaracteres($path){
        if(file_exists($path)){
            $file = fopen($path, 'r+') or die("can't open file");
            $status = fstat($file);
            ftruncate($file, $status['size']-3);
            fclose($file);
        } else {
            echo "error";
        }
    }
}
?>