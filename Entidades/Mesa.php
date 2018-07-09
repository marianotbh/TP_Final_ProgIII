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
    public static function Listar(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT codigo_mesa as codigo, estado, foto FROM mesa");
        
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Mesa");
        return $resultado; 
    }

    ///Baja de mesas.
    public static function Baja($codigo){
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM mesa WHERE codigo_mesa = :codigo");
    
            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
    
            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Mesa eliminada correctamente.");
        } 
        catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally{        
            return $respuesta;
        }
    }

    ///Actualizar la foto de la mesa.
    public static function ActualizarFoto($rutaFoto,$codigoMesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET foto = :rutaFoto WHERE codigo_mesa = :codigo");

        $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':rutaFoto', $rutaFoto, PDO::PARAM_STR);

        $consulta->execute();
    }

    ///Cambio de estado: Con cliente esperando pedido
    public static function EstadoEsperandoPedido($codigoMesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Con cliente esperando pedido' WHERE codigo_mesa = :codigo");

        $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

        $consulta->execute();

        return array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
    }

    ///Cambio de estado: Con clientes comiendo
    public static function EstadoComiendo($codigoMesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Con clientes comiendo' WHERE codigo_mesa = :codigo");

        $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

        $consulta->execute();

        return array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
    }

    ///Cambio de estado: Con clientes pagando
    public static function EstadoPagando($codigoMesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Con clientes pagando' WHERE codigo_mesa = :codigo");

        $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

        $consulta->execute();

        return array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
    }

    ///Cambio de estado: Cerrada
    public static function EstadoCerrada($codigoMesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado = 'Cerrada' WHERE codigo_mesa = :codigo");

        $consulta->bindValue(':codigo', $codigoMesa, PDO::PARAM_STR);

        $consulta->execute();

        return array("Estado" => "OK", "Mensaje" => "Cambio de estado exitoso.");
    }

}
?>