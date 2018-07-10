<?php
include_once("DB/AccesoDatos.php");
class Encuesta
{
    public $id;
    public $puntuacion_mesa;
    public $codigoMesa;
    public $puntuacion_restaurante;
    public $puntuacion_mozo;
    public $idMozo;
    public $puntuacion_cocinero;
    public $comentario;
    public $fecha;

    ///Registra una nueva encuesta
    public static function Registrar($puntuacion_mesa,$codigoMesa,$puntuacion_restaurante,$puntuacion_mozo,$puntuacion_cocinero,$comentario)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $fecha = date('Y-m-d H:i:s');
            $pedido = Pedido::ListarPorMesa($codigoMesa);
            $idMozo = $pedido[0]->id_mozo;


            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO encuesta (puntuacion_mesa, codigoMesa, puntuacion_restaurante,
                                                            puntuacion_mozo,idMozo,puntuacion_cocinero,comentario,fecha) 
                                                            VALUES (:puntuacion_mesa,:codigoMesa,:puntuacion_restaurante,:puntuacion_mozo,
                                                            :idMozo,:puntuacion_cocinero,:comentario,:fecha);");
            $consulta->bindValue(':puntuacion_mesa', $puntuacion_mesa, PDO::PARAM_INT);
            $consulta->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':puntuacion_restaurante', $puntuacion_restaurante, PDO::PARAM_INT);
            $consulta->bindValue(':puntuacion_mozo', $puntuacion_mozo, PDO::PARAM_INT);
            $consulta->bindValue(':idMozo', $idMozo, PDO::PARAM_INT);
            $consulta->bindValue(':puntuacion_cocinero', $puntuacion_cocinero, PDO::PARAM_INT);
            $consulta->bindValue(':comentario', $comentario, PDO::PARAM_STR);
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Encuesta registrada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Lista las encuestas
    public static function Listar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, puntuacion_mesa, codigoMesa, puntuacion_restaurante,
                                                            puntuacion_mozo,idMozo,puntuacion_cocinero,comentario,fecha FROM encuesta;");
            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Encuesta");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Lista las encuestas entre las fechas
    public static function ListarEntreFechas($fecha1,$fecha2)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, puntuacion_mesa, codigoMesa, puntuacion_restaurante,
                                                            puntuacion_mozo,idMozo,puntuacion_cocinero,comentario,fecha FROM encuesta
                                                            WHERE fecha BETWEEN :fecha1 AND :fecha2;");
            
            $consulta->bindValue(':fecha1', $fecha1, PDO::PARAM_STR);
            $consulta->bindValue(':fecha2', $fecha2, PDO::PARAM_STR);
            $consulta->execute();
            
            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Encuesta");
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