<?php
include_once("Entidades/Token.php");
include_once("Entidades/Menu.php");
class MenuApi extends Menu{  
    ///Registro de nuevas comidas
    public function RegistrarComida($request, $response, $args){
        $parametros = $request->getParsedBody();
        $nombre = $parametros["nombre"];  
        $precio = $parametros["precio"];  
        $sector = $parametros["sector"];            

        $respuesta = Menu::Registrar($nombre,$precio,$sector);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Modificacion del menu
    public function ModificarComida($request, $response, $args){
        $parametros = $request->getParsedBody();
        $id = $parametros["id"]; 
        $nombre = $parametros["nombre"];  
        $precio = $parametros["precio"];  
        $sector = $parametros["sector"];            

        $respuesta = Menu::Modificar($id,$nombre,$precio,$sector);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista el menú
    public function ListarMenu($request,$response,$args){
        $respuesta = Menu::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Da de baja una comida
    public function BajaMenu($request,$response,$args){
        $id = $args["id"];
        $respuesta = Menu::Baja($id);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}