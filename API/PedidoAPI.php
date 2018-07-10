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

    //Uno de los empleados toma el pedido para prepararlo, agregando un tiempo estimado de preparación.
    public function TomarPedidoPendiente($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $minutosEstimados = $parametros["minutosEstimados"];  
        $payload = $request->getAttribute("payload")["Payload"];
        $id_encargado = $payload->id;
        $respuesta = Pedido::TomarPedido($codigo,$id_encargado,$minutosEstimados);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Se informa que el pedido está listo para servir.
    public function InformarPedidoListoParaServir($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $respuesta = Pedido::InformarListoParaServir($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Devuelve el tiempo restante
    public function TiempoRestantePedido($request,$response,$args){
        $codigo = $args["codigoPedido"];
        $respuesta = Pedido::TiempoRestante($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Servir Pedido
    public function ServirPedido($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $respuesta = Pedido::Servir($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lo menos vendido
    public function LoMenosVendido($request,$response,$args){
        $respuesta = Pedido::MenosVendido();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lo más vendido
    public function LoMasVendido($request,$response,$args){
        $respuesta = Pedido::MasVendido();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    //Lista los pedidos fuera del tiempo estipulado.
    public function ListarPedidosFueraDelTiempoEstipulado($request,$response,$args){
        $respuesta = Pedido::ListarFueraDelTiempoEstipulado();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}