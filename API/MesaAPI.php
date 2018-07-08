<?php
include_once("Entidades/Token.php");
include_once("Entidades/Mesa.php");
class MesaApi extends Mesa{  
    ///Registro de nuevos empleados.
    public function RegistrarMesa($request, $response, $args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];            

        $respuesta = Mesa::Registrar($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todas las mesas
    public function ListarMesas($request,$response,$args){
        $respuesta = Mesa::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Da de baja una mesa
    public function BajaMesa($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Mesa::Baja($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}