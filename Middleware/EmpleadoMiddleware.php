<?php
    class EmpleadoMiddleware{
        public static function ValidarToken($request,$response,$next){
            $token = $request->getHeader("token");
            $validacionToken = Token::DecodificarToken($token[0]);
            if($validacionToken["Estado"] == "OK"){
                $request = $request->withAttribute("payload", $validacionToken);
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson($validacionToken,200);
                return $newResponse;
            }
        }

        public static function ValidarSocio($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];
            
            if($payload->tipo->tipo_empleado == "Socio"){
                return $next($request,$response);
            }
            else{
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "No tienes permiso para realizar esta accion (Solo categoria socio).");
                $newResponse = $response->withJson($respuesta,200);
                return $newResponse;
            }
        }

        // public static function ValidarEncargado($request,$response,$next){
        //     $payload = $request->getAttribute("payload")["Payload"];
            
        //     if($payload->tipoUser->tipo_usuario == "Encargado"){
        //         return $next($request,$response);
        //     }
        //     else{
        //         $newResponse = $response->withJson("ERROR: No tienes permiso para realizar esta accion (Solo categoria encargado).",200);
        //         return $newResponse;
        //     }
        // }

        // public static function ValidarEmpleadoOEncargado($request,$response,$next){
        //     $payload = $request->getAttribute("payload")["Payload"];
            
        //     if($payload->tipoUser->tipo_usuario == "Empleado" || $payload->tipoUser->tipo_usuario == "Encargado"){
        //         return $next($request,$response);
        //     }
        //     else{
        //         $newResponse = $response->withJson("ERROR: No tienes permiso para realizar esta accion (Solo categoria empleado o encargado).",200);
        //         return $newResponse;
        //     }
        // }
    }
?>