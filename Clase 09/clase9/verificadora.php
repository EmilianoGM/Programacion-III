<?php
class Verificadora
{
    public static function DeterminarVerbo($request, $response, $next)
    {
        $objJson = new stdClass();
        $objJson->Get = $request->isGet();
        $objJson->Post = $request->isPost();
        return $objJson;
    }

    public function Verificar($request, $response, $next){
        $objJson = Verificadora::DeterminarVerbo($request, $response, $next);
        if($objJson->Get){
            $response = $next($request, $response);
        }
        if($objJson->Post){
            $data = $request->getParsedBody();
            if(isset($data["tipo"]) && $data["tipo"] == "admin"){
                $usuario = new stdClass();
                $usuario->nombre = isset($data["nombre"]) ? $data["nombre"] : null;
                $usuario->clave = isset($data["clave"]) ? $data["clave"] : null;
                if(Verificadora::ExisteUsuario($usuario)){
                    $response = $next($request, $response);
                } else {
                    $response->getBody()->write("No existe");
                }
                
            }
            else{
                $response->getBody()->write("No tiene permisos");
            }
        }
        return $response;
    }

    public static function ExisteUsuario($obj){
        $destino = "./usuarios.txt";
        $resp = "";
        $flag = false;
        if(file_exists($destino)){
            $archivo = fopen($destino, "r");
            while(!feof($archivo)){
                $linea = fgets($archivo);
                $datos = explode("-", $linea);
                //$resp .= var_dump($datos);
                if(trim($datos[0]) === $obj->nombre && trim($datos[1]) === $obj->clave){
                    $flag = true;
                    break;
                }
            }
        }
        return $flag;
    }
}

?>