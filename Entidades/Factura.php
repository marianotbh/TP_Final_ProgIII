<?php
include_once("DB/AccesoDatos.php");
class Factura
{
    public $idFactura;
    public $importe;
    public $codigoMesa;
    public $fecha;

    ///Genera una nueva factura.
    public static function Generar($importe, $codigoMesa)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $fecha = date('Y-m-d H:i:s');
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO factura (importe, codigoMesa, fecha) 
                                                            VALUES (:importe, :codigoMesa, :fecha);");

            $consulta->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $consulta->bindValue(':importe', $importe, PDO::PARAM_INT);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Factura generada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }
}
?>