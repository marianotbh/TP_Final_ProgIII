<?php
include_once("Entidades/Token.php");
include_once("Entidades/Pedido.php");
class PedidoApi extends Pedido{  
    ///Registro de nuevos pedidos.
    public function RegistrarPedido($request, $response, $args){
        $parametros = $request->getParsedBody();
        $id_mesa = $parametros["id_mesa"];        
        $id_menu  = $parametros["id_menu"];
        $nombre_cliente = $parametros["cliente"];
        $payload = $request->getAttribute("payload")["Payload"];
        $id_mozo = $payload->id;       

        $respuesta = Pedido::Registrar($id_mesa,$id_menu,$id_mozo,$nombre_cliente);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos
    public function ListarTodosLosPedidos($request,$response,$args){
        $respuesta = Pedido::ListarTodos();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos por Fecha
    public function ListarTodosLosPedidosPorFecha($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha = $parametros["fecha"];  
        $respuesta = Pedido::ListarTodosPorFecha($fecha);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos por mesa
    public function ListarTodosLosPedidosPorMesa($request,$response,$args){
        $mesa = $args["codigoMesa"];  
        $respuesta = Pedido::ListarPorMesa($mesa);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos activos. Muestra los que correspondan según el perfil.
    public function ListarPedidosActivos($request,$response,$args){
        $payload = $request->getAttribute("payload")["Payload"];
        $id_empleado = $payload->id;
        $sector = $payload->tipo;
        $respuesta = Pedido::ListarActivosPorSector($sector,$id_empleado);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos cancelados
    public function ListarTodosLosPedidosCancelados($request,$response,$args){
        $respuesta = Pedido::ListarCancelados();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cancela un pedido.
    public function CancelarPedido($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Pedido::Cancelar($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}