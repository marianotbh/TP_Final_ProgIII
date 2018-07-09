<?php
    class EncuestaMiddleware{
        ///Valida los datos de la encuesta
        public static function ValidarEncuesta($request, $response, $next)
        {
            $parametros = $request->getParsedBody();
            $puntuacionMesa = $parametros["puntuacionMesa"];
            $codigoMesa = $parametros["codigoMesa"];
            $puntuacionRestaurante = $parametros["puntuacionRestaurante"];
            $puntuacionMozo = $parametros["puntuacionMozo"];
            $puntuacionCocinero = $parametros["puntuacionCocinero"];

            $mesa = Mesa::ObtenerPorCodigo($codigoMesa);

            if ($puntuacionMesa < 1 || $puntuacionMesa > 10 || $puntuacionRestaurante < 1 || $puntuacionRestaurante > 10 ||
            $puntuacionMozo < 1 || $puntuacionMozo > 10 || $puntuacionCocinero < 1 || $puntuacionCocinero > 10) {
                $retorno = array("Estado" => "ERROR", "Mensaje" => "La puntuación debe ser entre 1 y 10.");
                $newResponse = $response->withJson($retorno, 200);
            } else if ($mesa == null) {
                $retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo de mesa incorrecto.");
                $newResponse = $response->withJson($retorno, 200);
            }
            else {
                $newResponse = $next($request, $response);
            }

            return $newResponse;
        }
    }
?>