<?php
include_once("Entidades/Token.php");
include_once("Entidades/Empleado.php");
class EmpleadoApi extends Empleado{  
    ///Logueo de empleados.
    public function LoginEmpleado($request, $response, $args){
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];
        $clave  = $parametros["clave"];
        $retorno = Empleado::Login($usuario,$clave);

        if($retorno["tipo_empleado"] != ""){
            $token = Token::CodificarToken($usuario,$retorno["tipo_empleado"],$retorno["ID_Empleado"],$retorno["nombre_empleado"]);
            Empleado::ActualizarFechaLogin($retorno["ID_Empleado"]);
            $respuesta = array("Estado" => "OK", "Mensaje" => "Logueado exitosamente.", "Token" => $token, "Nombre_Empleado" => $retorno["nombre_empleado"]);            
        }
        else{
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario o clave invalidos.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }   

    ///Registro de nuevos empleados.
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

    ///Modifica un empleado
    public function ModificarEmpleado($request, $response, $args){
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];        
        $id  = $parametros["id"];
        $nombre = $parametros["nombre"];
        $tipo = $parametros["tipo"];
        
        $respuesta = Empleado::Modificar($id,$usuario,$nombre,$tipo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los empleados
    public function ListarEmpleados($request,$response,$args){
        $respuesta = Empleado::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Da de baja un empleado.
    public function BajaEmpleado($request,$response,$args){
        $id = $args["id"];
        $respuesta = Empleado::Baja($id);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Suspende un empleado.
    public function SuspenderEmpleado($request,$response,$args){
        $id = $args["id"];
        $respuesta = Empleado::Suspender($id);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambiar contraseña
    public function CambiarClaveEmpleado($request,$response,$args){
        $parametros = $request->getParsedBody();
        $clave = $parametros["clave"];  
        $payload = $request->getAttribute("payload")["Payload"];
        $id = $payload->id;
        $respuesta = Empleado::CambiarClave($id,$clave);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}