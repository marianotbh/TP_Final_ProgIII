<?php
class PedidoMiddleware
{
    public static function ValidarTomarPedido($request, $response, $next)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $pedido = Pedido::ObtenerPorCodigo($codigo);
        $payload = $request->getAttribute("payload")["Payload"];

        if ($pedido == null) {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo incorrecto.");
            $newResponse = $response->withJson($retorno, 200);
        } else if ($pedido[0]->estado != 'Pendiente') {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Este pedido no se encuentra pendiente.");
            $newResponse = $response->withJson($retorno, 200);
        } else if ($pedido[0]->sector != $payload->tipo) {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Este pedido pertenece a otro sector.");
            $newResponse = $response->withJson($retorno, 200);
        } else {
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }

    public static function ValidarInformarListoParaServir($request, $response, $next)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $pedido = Pedido::ObtenerPorCodigo($codigo);
        $payload = $request->getAttribute("payload")["Payload"];

        if ($pedido == null) {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo incorrecto.");
            $newResponse = $response->withJson($retorno, 200);
        } else if ($pedido[0]->estado != 'En Preparacion') {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Este pedido no se encuentra en preparacion.");
            $newResponse = $response->withJson($retorno, 200);
        } else if ($pedido[0]->id_encargado != $payload->id) {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Solo el encargado del pedido puede realizar esta accion.");
            $newResponse = $response->withJson($retorno, 200);
        } else {
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }

    public static function ValidarServir($request, $response, $next)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $pedido = Pedido::ObtenerPorCodigo($codigo);
        $payload = $request->getAttribute("payload")["Payload"];

        if ($pedido == null) {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo incorrecto.");
            $newResponse = $response->withJson($retorno, 200);
        } else if ($pedido[0]->estado != 'Listo para Servir') {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Este pedido no se encuentra listo para servir.");
            $newResponse = $response->withJson($retorno, 200);
        } else if ($pedido[0]->id_mozo != $payload->id) {
            $retorno = array("Estado" => "ERROR", "Mensaje" => "Solo el mozo encargado del pedido puede realizar esta accion.");
            $newResponse = $response->withJson($retorno, 200);
        } else {
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }
}
?>