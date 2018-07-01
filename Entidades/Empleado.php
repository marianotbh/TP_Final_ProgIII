<?php
include_once("DB/AccesoDatos.php");
class Empleado
{
    public $usuario;
    public $tipo;

    public static function Registrar($usuario, $clave, $nombre, $tipo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $fecha = date('Y-m-d H:i:s');

            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado (ID_tipo_empleado, nombre_empleado, usuario, 
                                                                clave, fecha_registro, estado) 
                                                                SELECT te.ID_tipo_empleado, :nombre, :usuario, :clave, :fecha, 'A'
                                                                FROM tipoempleado te WHERE Descripcion = :tipo AND Estado = 'A';");

            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Empleado registrado correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    public static function Login($user, $password)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT descripcion as tipo_empleado FROM tipoempleado te 
                                                            INNER JOIN empleado em on em.ID_tipo_empleado = te.ID_tipo_empleado 
                                                            WHERE em.usuario = :user AND em.clave = :password");

        $consulta->execute(array(":user" => $user, ":password" => $password));

        $resultado = $consulta->fetch();
        return $resultado;
    }

        // public static function ListarUsuarios(){
        //     $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        //     $consulta = $objetoAccesoDato->RetornarConsulta("SELECT u.usuario, tu.tipo_usuario FROM usuario u 
        //                                                     INNER JOIN tipo_usuario tu on u.id_tipo_usuario = tu.id_tipo_usuario");
            
        //     $consulta->execute();
            
        //     $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Usuario");
        //     return $resultado; 
        // }

}
?>