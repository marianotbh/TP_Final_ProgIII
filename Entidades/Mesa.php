<?php
include_once("DB/AccesoDatos.php");
class Mesa
{
    public $codigo;
    public $estado;
    public $foto;

    ///Registra una nueva mesa
    public static function Registrar($codigo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO mesa (codigo_mesa, estado) 
                                                            VALUES (:codigo, 'Cerrada');");

            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Mesa registrada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }
    
    ///Listado completo de mesas
    public static function Listar()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT codigo_mesa as codigo, estado, foto FROM mesa");

            $consulta->execute();

            $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Obtiene la mesa correspondiente al código
    public static function ObtenerPorCodigo($codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT codigo_mesa as codigo, estado, foto FROM mesa
                                                            WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);
            $consulta->execute();

            $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Baja de mesas.
    public static function Baja($codigo)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM mesa WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Mesa eliminada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Actualizar la foto de la mesa.
    public static function ActualizarFoto($rutaFoto, $codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET foto = :rutaFoto WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':rutaFoto', $rutaFoto, PDO::PARAM_STR);

            $consulta->execute();

            $resultado = array("Estado" => "OK", "Mensaje" => "Foto actualizada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Cambio de estado: Con cliente esperando pedido
    public static function EstadoEsperandoPedido($codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Con cliente esperando pedido' WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

            $consulta->execute();

            $resultado = array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }

    }

    ///Cambio de estado: Con clientes comiendo
    public static function EstadoComiendo($codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Con clientes comiendo' WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

            $consulta->execute();

            $resultado = array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Cambio de estado: Con clientes pagando
    public static function EstadoPagando($codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Con clientes pagando' WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

            $consulta->execute();

            $resultado = array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Cambio de estado: Cerrada
    public static function EstadoCerrada($codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Cerrada' WHERE codigo_mesa = :codigo");

            $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

            $consulta->execute();

            $resultado = array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Calcula el importe final y genera la factura. Finaliza todos los pedidos de la mesa. 
    public static function Cobrar($codigoMesa)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $pedidos = Pedido::ListarPorMesa($codigoMesa);
            $importeFinal = 0;
            foreach($pedidos as $pedido){
                if($pedido->estado == "Entregado"){
                    $importeFinal += $pedido->importe;
                }
            }

            Factura::Generar($importeFinal,$codigoMesa);
            Pedido::Finalizar($codigoMesa);

            $resultado = array("Estado" => "OK", "Mensaje" => "Se ha cobrado a la mesa con exito.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Mesa más usada
    public static function MasUsada()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, count(f.codigoMesa) as cantidad_usos FROM factura f 
                                                            GROUP BY(f.codigoMesa) HAVING count(f.codigoMesa) = 
                                                            (SELECT MAX(sel.cantidad_usos) FROM 
                                                            (SELECT count(f2.codigoMesa) as cantidad_usos FROM factura f2 GROUP BY(f2.codigoMesa)) sel);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    
    ///Mesa más usada
    public static function MenosUsada()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, count(f.codigoMesa) as cantidad_usos FROM factura f 
                                                            GROUP BY(f.codigoMesa) HAVING count(f.codigoMesa) = 
                                                            (SELECT MIN(sel.cantidad_usos) FROM 
                                                            (SELECT count(f2.codigoMesa) as cantidad_usos FROM factura f2 GROUP BY(f2.codigoMesa)) sel);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Mesa que más facturó
    public static function MasFacturacion()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, SUM(f.importe) as facturacion_total FROM factura f 
                                                            GROUP BY(f.codigoMesa) HAVING SUM(f.importe) = 
                                                            (SELECT MAX(sel.facturacion_total) FROM
                                                            (SELECT SUM(f2.importe) as facturacion_total FROM factura f2 GROUP BY(f2.codigoMesa)) sel);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Mesa que menos facturó
    public static function MenosFacturacion()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, SUM(f.importe) as facturacion_total FROM factura f 
                                                            GROUP BY(f.codigoMesa) HAVING SUM(f.importe) = 
                                                            (SELECT MIN(sel.facturacion_total) FROM
                                                            (SELECT SUM(f2.importe) as facturacion_total FROM factura f2 GROUP BY(f2.codigoMesa)) sel);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Mesa que tiene la factura con más importe
    public static function ConFacturaConMasImporte()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, f.importe as importe FROM factura f WHERE f.importe = 
                                                            (SELECT MAX(f2.importe) as importe FROM factura f2 ) GROUP BY (f.codigoMesa);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }


    ///Mesa que tiene la factura con menos importe
    public static function ConFacturaConMenosImporte()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, f.importe as importe FROM factura f WHERE f.importe = 
                                                            (SELECT MIN(f2.importe) as importe FROM factura f2 ) GROUP BY (f.codigoMesa);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Mesa que tiene la mejor puntuacion
    public static function ConMejorPuntuacion()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, AVG(f.puntuacion_mesa) as puntuacion_promedio FROM encuesta f 
                                                            GROUP BY(f.codigoMesa) HAVING AVG(f.puntuacion_mesa) = 
                                                            (SELECT MAX(sel.puntuacion_promedio) FROM
                                                            (SELECT AVG(f2.puntuacion_mesa) as puntuacion_promedio FROM encuesta f2 GROUP BY(f2.codigoMesa)) sel);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }

    ///Mesa que tiene la peor puntuacion
    public static function ConPeorPuntuacion()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, AVG(f.puntuacion_mesa) as puntuacion_promedio FROM encuesta f 
                                                            GROUP BY(f.codigoMesa) HAVING AVG(f.puntuacion_mesa) = 
                                                            (SELECT MIN(sel.puntuacion_promedio) FROM
                                                            (SELECT AVG(f2.puntuacion_mesa) as puntuacion_promedio FROM encuesta f2 GROUP BY(f2.codigoMesa)) sel);");

            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }


    ///Facturacion entre 2 fechas para una mesa
    public static function FacturacionEntreFechas($codigoMesa,$fecha1,$fecha2)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT f.codigoMesa, f.fecha, f.importe FROM factura f 
                                                            WHERE f.codigoMesa = :codigoMesa AND f.fecha BETWEEN :fecha1 AND :fecha2;");

            $consulta->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':fecha1', $fecha1, PDO::PARAM_STR);
            $consulta->bindValue(':fecha2', $fecha2, PDO::PARAM_STR);
            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $resultado;
        }
    }
}
?>