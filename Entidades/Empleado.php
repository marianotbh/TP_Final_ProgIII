<?php
include_once("DB/AccesoDatos.php");
class Empleado
{
    public $id;
    public $nombre;
    public $tipo;
    public $usuario;
    public $fechaRegistro;
    public $ultimoLogin;
    public $estado;
    public $cantidad_operaciones;

    ///Registra un nuevo empleado
    public static function Registrar($usuario, $clave, $nombre, $tipo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $fecha = date('Y-m-d H:i:s');

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT ID_tipo_empleado FROM tipoempleado WHERE Descripcion = :tipo AND Estado = 'A';");

            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->execute();
            $id_tipo = $consulta->fetch();

            if ($id_tipo != null) {
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado (ID_tipo_empleado, nombre_empleado, usuario, 
                clave, fecha_registro, estado) 
                VALUES (:id_tipo, :nombre, :usuario, :clave, :fecha, 'A');");

                $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
                $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
                $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
                $consulta->bindValue(':id_tipo', $id_tipo[0], PDO::PARAM_INT);

                $consulta->execute();

                $respuesta = array("Estado" => "OK", "Mensaje" => "Empleado registrado correctamente.");
            } else {
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Debe ingresar un tipo de empleado valido");
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Logueo de empleados
    public static function Login($user, $password)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT te.descripcion as tipo_empleado, em.ID_Empleado, nombre_empleado FROM empleado em
                                                            INNER JOIN tipoempleado te  on em.ID_tipo_empleado = te.ID_tipo_empleado 
                                                            WHERE em.usuario = :user AND em.clave = :password AND em.estado = 'A'");

        $consulta->execute(array(":user" => $user, ":password" => $password));

        $resultado = $consulta->fetch();
        return $resultado;
    }

    ///Actualiza la ultima fecha de logueo de los empleados.
    public static function ActualizarFechaLogin($id_empleado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date('Y-m-d H:i:s');

        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado SET fecha_ultimo_login = :fecha WHERE ID_Empleado = :id");

        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->bindValue(':id', $id_empleado, PDO::PARAM_INT);

        $consulta->execute();
    }

    ///Baja de empleados.
    public static function Baja($id_empleado)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado SET estado = 'B' WHERE ID_Empleado = :id");

            $consulta->bindValue(':id', $id_empleado, PDO::PARAM_INT);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Empleado dado de baja correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Suspender empleados.
    public static function Suspender($id_empleado)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado SET estado = 'S' WHERE ID_Empleado = :id");

            $consulta->bindValue(':id', $id_empleado, PDO::PARAM_INT);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Empleado suspendido correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Modificación de empleados
    public static function Modificar($id_empleado, $usuario, $nombre, $tipo)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT ID_tipo_empleado FROM tipoempleado WHERE Descripcion = :tipo AND Estado = 'A';");

            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->execute();
            $id_tipo = $consulta->fetch();

            if ($id_tipo != null) {
                $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado set ID_tipo_empleado = :id_tipo, nombre_empleado = :nombre, usuario = :usuario
                                                                WHERE id_empleado = :id_empleado");

                $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
                $consulta->bindValue(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $consulta->bindValue(':id_tipo', $id_tipo[0], PDO::PARAM_INT);

                $consulta->execute();

                $respuesta = array("Estado" => "OK", "Mensaje" => "Empleado modificado correctamente.");
            } else {
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Debe ingresar un tipo de empleado valido");
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Listado completo de empleados
    public static function Listar()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT em.ID_empleado as id, te.Descripcion as tipo, em.nombre_empleado as nombre, 
                                                        em.usuario, em.fecha_registro as fechaRegistro, em.fecha_ultimo_login as ultimoLogin, em.estado,
                                                        em.cantidad_operaciones 
                                                        FROM empleado em INNER JOIN tipoempleado te on em.id_tipo_empleado = te.id_tipo_empleado");

            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Cambiar clave de empleado.
    public static function CambiarClave($id_empleado, $nuevaClave)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado SET clave = :clave WHERE id_empleado = :id_empleado");

            $consulta->bindValue(':clave', $nuevaClave, PDO::PARAM_STR);
            $consulta->bindValue(':id_empleado', $id_empleado, PDO::PARAM_INT);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Clave modificada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Sumar 1 operacion al empleado
    public static function SumarOperacion($id_empleado)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado 
                                                            SET cantidad_operaciones = cantidad_operaciones + 1
                                                            WHERE id_empleado = :id_empleado");

            $consulta->bindValue(':id_empleado', $id_empleado, PDO::PARAM_INT);

            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Operación sumada correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Cantidad de operaciones de todos por sector
    public static function CantidadOperacionesPorSector()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT te.descripcion as sector, SUM(em.cantidad_operaciones) as cantidad_operaciones FROM empleado em
                                                            INNER JOIN tipoempleado te on em.id_tipo_empleado = te.id_tipo_empleado
                                                            GROUP BY(te.descripcion)");

            $consulta->execute();

            $respuesta = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Cantidad de operaciones de todos por sector
    public static function CantidadOperacionesEmpleadosPorSector($sector)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT te.descripcion as sector, em.nombre_empleado, em.id_empleado, 
                                                            em.cantidad_operaciones as cantidad_operaciones FROM empleado em
                                                            INNER JOIN tipoempleado te on em.id_tipo_empleado = te.id_tipo_empleado WHERE te.descripcion = :sector");

            $consulta->bindValue(':sector', $sector, PDO::PARAM_STR);
            $consulta->execute();

            $respuesta = $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Listado completo de empleados entre fechas de login
    public static function ListarEntreFechasLogin($fecha1,$fecha2)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT em.ID_empleado as id, te.Descripcion as tipo, em.nombre_empleado as nombre, 
                                                        em.usuario, em.fecha_registro as fechaRegistro, em.fecha_ultimo_login as ultimoLogin, em.estado,
                                                        em.cantidad_operaciones 
                                                        FROM empleado em INNER JOIN tipoempleado te on em.id_tipo_empleado = te.id_tipo_empleado
                                                        WHERE fecha_ultimo_login BETWEEN :fecha1 AND :fecha2");
            $consulta->bindValue(':fecha1', $fecha1, PDO::PARAM_STR);
            $consulta->bindValue(':fecha2', $fecha2, PDO::PARAM_STR);
            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Listado completo de empleados entre fechas de registro
    public static function ListarEntreFechasRegistro($fecha1,$fecha2)
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT em.ID_empleado as id, te.Descripcion as tipo, em.nombre_empleado as nombre, 
                                                        em.usuario, em.fecha_registro as fechaRegistro, em.fecha_ultimo_login as ultimoLogin, em.estado,
                                                        em.cantidad_operaciones 
                                                        FROM empleado em INNER JOIN tipoempleado te on em.id_tipo_empleado = te.id_tipo_empleado
                                                        WHERE fecha_registro BETWEEN :fecha1 AND :fecha2");
            $consulta->bindValue(':fecha1', $fecha1, PDO::PARAM_STR);
            $consulta->bindValue(':fecha2', $fecha2, PDO::PARAM_STR);
            $consulta->execute();

            $respuesta = $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");
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