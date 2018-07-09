<?php
include_once("Entidades/Token.php");
include_once("Entidades/Factura.php");
class FacturaApi extends Factura{ 
    ///Publica las facturas a pdf.
    public function ListarVentasPDF($request,$response,$args){
        $respuesta = Factura::ListarPDF();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 

    ///Publica las facturas a excel.
    public function ListarVentasExcel($request,$response,$args){
        $respuesta = Factura::ListarExcel();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 
}