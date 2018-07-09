<?php
include_once("Entidades/Token.php");
include_once("Entidades/Mesa.php");
include_once("Entidades/Foto.php");
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

    ///Actualiza la foto de la mesa
    public function ActualizarFotoMesa($request, $response, $args){
        $parametros = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $codigoMesa = $parametros["codigo"];
        $foto = $files["foto"];
 
        //Consigo la extensión de la foto.  
        $ext = Foto::ObtenerExtension($foto);
        if($ext != "ERROR"){
            //Guardo la foto.
            $rutaFoto = "./Fotos/Mesas/".$codigoMesa.".".$ext;
            Foto::GuardarFoto($foto,$rutaFoto);

            Mesa::ActualizarFoto($rutaFoto,$codigoMesa);
            $respuesta = array("Estado" => "OK", "Mensaje" => "Foto actualizada correctamente.");
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }
        else{
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }        
    }

    ///Cambio de estado: Con cliente esperando pedido
    public function CambiarEstado_EsperandoPedido($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Mesa::EstadoEsperandoPedido($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambio de estado: Con clientes comiendo
    public function CambiarEstado_Comiendo($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Mesa::EstadoComiendo($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambio de estado: Con clientes pagando
    public function CambiarEstado_Pagando($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Mesa::EstadoPagando($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambio de estado: Cerrada
    public function CambiarEstado_Cerrada($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Mesa::EstadoCerrada($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }


}