<?php
include_once("Entidades/Token.php");
include_once("Entidades/Encuesta.php");
class EncuestaApi extends Encuesta{  
    ///Registro de nueva encuesta.
    public function RegistrarEncuesta($request, $response, $args){
        $parametros = $request->getParsedBody();
        $puntuacionMesa = $parametros["puntuacionMesa"];
        $codigoMesa = $parametros["codigoMesa"];
        $puntuacionRestaurante = $parametros["puntuacionRestaurante"];
        $puntuacionMozo = $parametros["puntuacionMozo"];
        $puntuacionCocinero = $parametros["puntuacionCocinero"];
        $comentario = $parametros["comentario"];
        
        $respuesta = Encuesta::Registrar($puntuacionMesa,$codigoMesa,$puntuacionRestaurante,$puntuacionMozo,$puntuacionCocinero,$comentario);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Listar encuestas
    public function ListarEncuestas($request,$response,$args){
        $respuesta = Encuesta::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todas las encuestas entre las fechas
    public function ListarEncuestasEntreFechas($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = Encuesta::ListarEntreFechas($fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 
}