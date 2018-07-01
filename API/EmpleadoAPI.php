<?php
include_once("Entidades/Token.php");
include_once("Entidades/Empleado.php");
class EmpleadoApi extends Empleado{  
    public function LoginEmpleado($request, $response, $args){
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];
        $clave  = $parametros["clave"];
        $tipo = Empleado::Login($usuario,$clave);
        if($tipo != ""){
            $token = Token::CodificarToken($usuario,$tipo);
            $respuesta = array("Estado" => "OK", "Mensaje" => "Logueado exitosamente.", "Token" => $token);            
        }
        else{
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario o clave invalidos.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }   

    public function RegistrarEmpleado($request, $response, $args){
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];        
        $clave  = $parametros["clave"];
        $nombre = $parametros["nombre"];
        $tipo = $parametros["tipo"];
        

        $respuesta = Empleado::Registrar($usuario,$clave,$nombre,$tipo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}