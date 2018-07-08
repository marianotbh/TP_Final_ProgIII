<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
include_once './API/EmpleadoAPI.php';
include_once './API/MesaAPI.php';
include_once './API/MenuAPI.php';
include_once './API/PedidoAPI.php';
include_once './Middleware/EmpleadoMiddleware.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

//Empleados
$app->post('/empleados/login[/]', \EmpleadoAPI::class . ':LoginEmpleado');  
$app->post('/empleados/registrarEmpleado[/]', \EmpleadoAPI::class . ':RegistrarEmpleado')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');   
$app->get('/empleados/listar[/]', \EmpleadoAPI::class . ':ListarEmpleados')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');   
$app->delete('/empleados/{id}[/]', \EmpleadoAPI::class . ':BajaEmpleado')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');  
$app->delete('/empleados/suspender/{id}[/]', \EmpleadoAPI::class . ':SuspenderEmpleado')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
$app->post('/empleados/modificar[/]', \EmpleadoAPI::class . ':ModificarEmpleado')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');  
$app->post('/empleados/cambiarClave[/]', \EmpleadoAPI::class . ':CambiarClaveEmpleado')
->add(\EmpleadoMiddleware::class . ':ValidarToken');

//Mesas
$app->post('/mesas/registrar[/]', \MesaAPI::class . ':RegistrarMesa')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');   
$app->get('/mesas/listar[/]', \MesaAPI::class . ':ListarMesas')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');   
$app->delete('/mesas/{codigo}[/]', \MesaAPI::class . ':BajaMesa')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken'); 

//Menu
$app->post('/menu/registrar[/]', \MenuAPI::class . ':RegistrarComida')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');  
$app->post('/menu/modificar[/]', \MenuAPI::class . ':ModificarComida')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
$app->get('/menu/listar[/]', \MenuAPI::class . ':ListarMenu')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');   
$app->delete('/menu/{id}[/]', \MenuAPI::class . ':BajaMenu')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken'); 

//Pedido
$app->post('/pedido/registrar[/]', \PedidoAPI::class . ':RegistrarPedido')
->add(\EmpleadoMiddleware::class . ':ValidarMozo')
->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
$app->delete('/pedido/{codigo}[/]', \PedidoAPI::class . ':CancelarPedido')
->add(\EmpleadoMiddleware::class . ':ValidarMozo')
->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
$app->get('/pedido/listarTodos[/]', \PedidoAPI::class . ':ListarTodosLosPedidos')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');
$app->get('/pedido/listarCancelados[/]', \PedidoAPI::class . ':ListarTodosLosPedidosCancelados')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');  
$app->post('/pedido/listarTodosPorFecha[/]', \PedidoAPI::class . ':ListarTodosLosPedidosPorFecha')
->add(\EmpleadoMiddleware::class . ':ValidarSocio')
->add(\EmpleadoMiddleware::class . ':ValidarToken');  
$app->get('/pedido/listarPorMesa/{codigoMesa}[/]', \PedidoAPI::class . ':ListarTodosLosPedidosPorMesa');
$app->get('/pedido/listarActivos[/]', \PedidoAPI::class . ':ListarPedidosActivos')
->add(\EmpleadoMiddleware::class . ':ValidarToken');  





$app->run();