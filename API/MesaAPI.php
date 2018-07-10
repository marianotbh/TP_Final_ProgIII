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

            $respuesta = Mesa::ActualizarFoto($rutaFoto,$codigoMesa);
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

    ///Calcula el importe final y genera la factura. Finaliza todos los pedidos de la mesa. 
    public function CobrarMesa($request,$response,$args){
        $codigo = $args["codigo"];
        $respuesta = Mesa::Cobrar($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa más usada.
    public function MesaMasUsada($request,$response,$args){
        $respuesta = Mesa::MasUsada();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa menos usada.
    public function MesaMenosUsada($request,$response,$args){
        $respuesta = Mesa::MenosUsada();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que más facturó
    public function MesaMasFacturacion($request,$response,$args){
        $respuesta = Mesa::MasFacturacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que menos facturó
    public function MesaMenosFacturacion($request,$response,$args){
        $respuesta = Mesa::MenosFacturacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la factura con más importe
    public function MesaConFacturaConMasImporte($request,$response,$args){
        $respuesta = Mesa::ConFacturaConMasImporte();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la factura con menos importe
    public function MesaConFacturaConMenosImporte($request,$response,$args){
        $respuesta = Mesa::ConFacturaConMenosImporte();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la mejor puntuacion
    public function MesaConMejorPuntuacion($request,$response,$args){
        $respuesta = Mesa::ConMejorPuntuacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la peor puntuacion
    public function MesaConPeorPuntuacion($request,$response,$args){
        $respuesta = Mesa::ConPeorPuntuacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Facturacion entre 2 fechas para una mesa
    public function MesaFacturacionEntreFechas($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigoMesa = $parametros["codigoMesa"];
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = Mesa::FacturacionEntreFechas($codigoMesa,$fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}