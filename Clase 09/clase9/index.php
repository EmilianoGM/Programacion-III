<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once "./verificadora.php";

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);


$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

/*
COMPLETAR POST, PUT Y DELETE
*/
$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;

});

/* get con parametros */
$app->get('/parametros/{nombre}[/{apellido}]', function (Request $request, Response $response, $param) {    
    $mensaje = "Bienvenido ". $param["nombre"];
    if(isset($param["apellido"])){
        $mensaje .= " " . $param["apellido"];
    }
    $response->getBody()->write($mensaje);
    return $response;

});

/**con grupos */
/*$app->group("/grupo", function() use ($app){
    $app->get('/parametros/{nombre}[/{apellido}]', function (Request $request, Response $response, $param) {    
        $mensaje = "Grupos, Bienvenido ". $param["nombre"];
        if(isset($param["apellido"])){
            $mensaje .= " " . $param["apellido"];
        }
        $response->getBody()->write($mensaje);
        return $response;
    });

    /**Con Json *//*
    $app->get('/parametros', function (Request $request, Response $response, $param) {
        $obj = new stdClass();
        $obj->nombre = "juan";
        $obj->apellido = "perez";   
        $nuevaRespuesta = $response->withJson($obj);
        return $nuevaRespuesta;
    });

    $app->delete('/parametros', function (Request $request, Response $response, $args) {    
        $data = $request->getParsedBody();
        $mensaje = "Delete ";
        if(isset($data["usuario"])){
            $objJson = json_decode($data["usuario"]);
            $nombre = $objJson->nombre;
            $objJson->nombre = $objJson->apellido;
            $objJson->apellido = $nombre;
            $mensaje .= json_encode($objJson);
        }
        $response->getBody()->write($mensaje);
        return $response;
    
    });

    $app->put('/parametros', function (Request $request, Response $response, $args) {    
        $data = $request->getParsedBody();
        $mensaje = "Put ";
        if(isset($data["usuario"])){
            $objJson = json_decode($data["usuario"]);
            $nombre = $objJson->nombre;
            $objJson->nombre = $objJson->apellido;
            $objJson->apellido = $nombre;
            $mensaje .= json_encode($objJson);
        }
        $response->getBody()->write($mensaje);
        return $response;
    
    });
    /** Con foto *//*
    $app->post('/parametros', function (Request $request, Response $response, $args) {
        $archivo = $request->getUploadedFiles();
        if ($archivo["foto"]->getError() === UPLOAD_ERR_OK) {
        $filename = $archivo["foto"]->moveTo("./fotos/". date("his") . ".jpg");
            $response->getBody()->write('uploaded' . $filename . '<br/>');
        }
        return $response;
    
    });
    /*
    $app->post('/parametros', function (Request $request, Response $response, $args) {

        $response->getBody()->write(var_dump($request->getParsedBody()));
        return $response;
    
    });
    *//*
    $app->put('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Group PUT => Bienvenido!!! a SlimFramework");
        return $response;
    
    });

    $app->delete('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Group DELETE => Bienvenido!!! a SlimFramework");
        return $response;
    
    });
});*/

/**Ejemplo uso de middleware */
$app->group("/credenciales", function() use ($app){
    $app->get('[/]', function (Request $request, Response $response) {
      $response->getBody()->write("GET => grupo credenciales");
      return $response;
    });
  
    $app->post('[/]', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $nombre = isset($data["nombre"]) ? $data["nombre"] : "no hay nombre";
        $response->getBody()->write("El nombre es " . $nombre);
        return $response;
    });
  
})->add(Verificadora::class . ":Verificar");

/*
add(function ($request, $response, $next) {
    if($request->isGet()){
        $response = $next($request, $response);
    } else if($request->isPost()){
        $data = $request->getParsedBody();
        if(isset($data["tipo"]) && $data["tipo"] == "admin"){
            $response = $next($request, $response);
        }
        else{
            $response->getBody()->write("No tiene permisos");
        }
    } else{
        $metodo = $request->getMethod();
        $response->getBody()->write("El metodo es " . $metodo);
    }
	return $response;
});
*/
$app->run();