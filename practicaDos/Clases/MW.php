<?php
require_once './CLASES/Usuario.php';

class MiddleWare
{
    public static function VerificarPerfilPropietario($request, $response, $next)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo en usuario";

        $datos = $request->getParsedBody();
        $datosJSON = json_decode($datos['usuario']);
        if($datosJSON->perfil == "propietario"){
            $usuario = new Usuario(null, $datosJSON->correo, $datosJSON->clave, $datosJSON->nombre, $datosJSON->apellido, $datosJSON->perfil);
            if($usuario->ExisteDB()){
                $objRetorno->Exito = true;
                $response = $next($request, $response);
            } else{
                $objRetorno->Mensaje = "Usuario inexistente";
            }
        } else{
            $objRetorno->Mensaje = "No es propietario";
        }

        if(!($objRetorno->Exito)){
            $response = $response->withJson($objRetorno, 409);
        }

        return $response;
    }

    public function VerificarPerfilEncargado($request, $response, $next)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo en usuario";

        $datos = $request->getParsedBody();
        $datosJSON = json_decode($datos['usuario']);
        if($datosJSON->perfil == "propietario" || $datosJSON->perfil == "encargado"){
            $usuario = new Usuario(null, $datosJSON->correo, $datosJSON->clave, $datosJSON->nombre, $datosJSON->apellido, $datosJSON->perfil);
            if($usuario->ExisteDB()){
                $objRetorno->Exito = true;
                $response = $next($request, $response);
            } else{
                $objRetorno->Mensaje = "Usuario inexistente";
            }
        } else{
            $objRetorno->Mensaje = "No es propietario o encargado";
        }

        if(!($objRetorno->Exito)){
            $response = $response->withJson($objRetorno, 409);
        }
        
        return $response;
    }

    public static function VerificarPerfilEmpleado($request, $response, $next)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo en usuario";

        $datos = $request->getParsedBody();
        $datosJSON = json_decode($datos['usuario']);
        if($datosJSON->perfil == "empleado"){
            $usuario = new Usuario(null, $datosJSON->correo, $datosJSON->clave, $datosJSON->nombre, $datosJSON->apellido, $datosJSON->perfil);
            if($usuario->ExisteDB()){
                $objRetorno->Exito = true;
                $response = $next($request, $response);
            } else{
                $objRetorno->Mensaje = "Usuario inexistente";
            }
        } else{
            $objRetorno->Mensaje = "No es empleado";
        }

        if(!($objRetorno->Exito)){
            $response = $response->withJson($objRetorno, 409);
        }
        
        return $response;
    }

    public function CorreoYClaveSeteados($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        if(isset($arrayParams['correo']) && isset($arrayParams['clave'])) {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'Correo o clave no seteados';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }
    public static function CorreoYClaveNoVacios($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        if($arrayParams['correo'] != "" && $arrayParams['clave'] != "") {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'Correo o clave vacios';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }
    /*public function CorreoYClaveEnBD($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $correo = $arrayParams['correo'];
        $clave = $arrayParams['clave'];
        $existeEnBD = Usuario::ExisteEnBD($correo, $clave);
        if(!$existeEnBD) {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'El correo o la clave ya existen en la base de datos';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }*/
}
?>