<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
include_once './API/EmpleadoAPI.php';
include_once './Middleware/EmpleadoMiddleware.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->get('[/]', function ($request, $response, $args) {
    $file = './Frontend/index.html';
    if (file_exists($file)) {
        return $response->write(file_get_contents($file));
    } else {
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
});

$app->post('/empleados/login[/]', \EmpleadoAPI::class . ':LoginEmpleado');  
$app->post('/empleados/registrarEmpleado[/]', \EmpleadoAPI::class . ':RegistrarEmpleado')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');   


$app->run();