<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './CLASES/Usuario.php';
require_once './CLASES/Media.php';
require_once './CLASES/Venta.php';
require_once './CLASES/MW.php';

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->get('/a', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});


$app->get('/medias', \Media::class . '::ListadoMedias');

$app->post('/', \Media::class . '::AltaMedia');

$app->put('/', \Media::class . '::ModificarMedia')->add(\MiddleWare::class . ":VerificarPerfilEncargado");

$app->delete('/', \Media::class . '::EliminarMedia')->add(\MiddleWare::class . "::VerificarPerfilPropietario");


$app->get('[/]', \Usuario::class . '::ListadoUsuarios');

$app->post('/usuarios', \Usuario::class . '::AltaUsuario');

$app->get('/listadoFotos', \Usuario::class . '::TablaUsuarios');


$app->post('/ventas', \Venta::class . '::AltaVenta');

$app->get('/ventas', \Venta::class . '::ListadoVentas'); 

$app->put('/ventas', \Venta::class . '::ModificarVenta')->add(\MiddleWare::class . ":VerificarPerfilEmpleado");

$app->delete('/ventas', \Venta::class . '::EliminarVenta')->add(\MiddleWare::class . "::VerificarPerfilEmpleado");



$app->run();