<?php
include_once("DB/AccesoDatos.php");
class Pedido
{
    public $codigo;
    public $estado;
    public $mesa;
    public $descripcion;
    public $id_menu;
    public $sector;
    public $nombre_cliente;
    public $nombre_mozo;
    public $id_mozo;
    public $id_encargado;
    public $hora_inicial;
    public $hora_entrega_estimada;
    public $hora_entrega_real;
    public $fecha;

    ///Registra un nuevo pedido
    public static function Registrar($id_mesa, $id_menu, $id_mozo,$nombre_cliente)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        try {          
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT Count(*) FROM menu m, mesa me, empleado em
                                                            INNER JOIN tipoempleado te ON em.ID_tipo_empleado = te.id_tipo_empleado 
                                                            WHERE m.id = :id_menu AND em.ID_empleado = :id_mozo
                                                            AND me.codigo_mesa = :id_mesa AND em.estado = 'A' AND te.Descripcion = 'Mozo';");
            
            $consulta->bindValue(':id_menu', $id_menu, PDO::PARAM_INT);
            $consulta->bindValue(':id_mozo', $id_mozo, PDO::PARAM_INT);
            $consulta->bindValue(':id_mesa', $id_mesa, PDO::PARAM_STR);
            $consulta->execute();
            $validacion = $consulta->fetch();
                      
            if($validacion[0] > 0){
                $codigo = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
                
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fecha = date('Y-m-d');
                $hora_inicial = date('H:i');
                
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO pedido (codigo, id_estado_pedidos, fecha, hora_inicial, 
                                                                id_mesa, id_menu, id_mozo, nombre_cliente) 
                                                                VALUES (:codigo, 1, :fecha, :hora_inicial, 
                                                                :id_mesa, :id_menu, :id_mozo, :nombre_cliente);");                

                $consulta->bindValue(':id_menu', $id_menu, PDO::PARAM_INT);
                $consulta->bindValue(':id_mozo', $id_mozo, PDO::PARAM_INT);
                $consulta->bindValue(':id_mesa', $id_mesa, PDO::PARAM_STR);
                $consulta->bindValue(':nombre_cliente', $nombre_cliente, PDO::PARAM_STR);
                $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
                $consulta->bindValue(':hora_inicial', $hora_inicial, PDO::PARAM_STR);
                $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
                $consulta->execute();

                $respuesta = array("Estado" => "OK", "Mensaje" => "Pedido registrado correctamente.");
            }
            else{
                $respuesta = array("Estado" => "ERROR", "Mensaje" => "Alguno de los ID ingresados es inválido.");
            }                        
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally {
            return $respuesta;
        }
    }

    ///Cancelar pedido.
    public static function Cancelar($codigo){
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedido SET id_estado_pedidos = 5 WHERE codigo = :codigo");
    
            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
    
            $consulta->execute();

            $respuesta = array("Estado" => "OK", "Mensaje" => "Pedido cancelado correctamente.");
        } 
        catch (Exception $e) {
            $mensaje = $e->getMessage();
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally{        
            return $respuesta;
        }
    }

    ///Listado completo de pedidos
    public static function ListarTodos(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                        me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                        em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                        p.hora_entrega_real, p.fecha
                                                        FROM pedido p
                                                        INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                        INNER JOIN menu me ON me.id = p.id_menu
                                                        INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                        INNER JOIN empleado em ON em.ID_empleado = p.id_mozo");
        
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Pedido");
        return $resultado; 
    }

    ///Listado completo de pedidos por fecha
    public static function ListarTodosPorFecha($fecha){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                        me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                        em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                        p.hora_entrega_real, p.fecha
                                                        FROM pedido p
                                                        INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                        INNER JOIN menu me ON me.id = p.id_menu
                                                        INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                        INNER JOIN empleado em ON em.ID_empleado = p.id_mozo
                                                        WHERE p.fecha = :fecha");
        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Pedido");
        return $resultado; 
    }

    ///Listado de pedidos por mesa. No muestra cancelados ni finalizados.  
    public static function ListarPorMesa($mesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                        me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                        em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                        p.hora_entrega_real, p.fecha
                                                        FROM pedido p
                                                        INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                        INNER JOIN menu me ON me.id = p.id_menu
                                                        INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                        INNER JOIN empleado em ON em.ID_empleado = p.id_mozo
                                                        WHERE p.id_mesa = :mesa AND ep.descripcion NOT IN ('Cancelado','Finalizado')");
        $consulta->bindValue(':mesa', $mesa, PDO::PARAM_STR);
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Pedido");
        return $resultado; 
    }

    ///Listado de pedidos por sector. No muestra cancelados ni finalizados.
    public static function ListarActivosPorSector($sector,$id_empleado){      
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        switch($sector){
            //Si es socio los lista a todos.
            case "Socio":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                                me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                                em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                                p.hora_entrega_real, p.fecha
                                                                FROM pedido p
                                                                INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                                INNER JOIN menu me ON me.id = p.id_menu
                                                                INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                                INNER JOIN empleado em ON em.ID_empleado = p.id_mozo
                                                                WHERE ep.descripcion NOT IN ('Cancelado','Finalizado')");
                break;
            //Si es mozo lista los de ese mozo.
            case "Mozo":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                            me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                            em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                            p.hora_entrega_real, p.fecha
                                                            FROM pedido p
                                                            INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                            INNER JOIN menu me ON me.id = p.id_menu
                                                            INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                            INNER JOIN empleado em ON em.ID_empleado = p.id_mozo
                                                            WHERE p.id_mozo = :id_mozo AND ep.descripcion NOT IN ('Cancelado','Finalizado')");
                $consulta->bindValue(':id_mozo', $id_empleado, PDO::PARAM_STR);
                break;
            //Para los demás lista por sector.
            default:
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                            me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                            em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                            p.hora_entrega_real, p.fecha
                                                            FROM pedido p
                                                            INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                            INNER JOIN menu me ON me.id = p.id_menu
                                                            INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                            INNER JOIN empleado em ON em.ID_empleado = p.id_mozo
                                                            WHERE te.descripcion = :sector AND ep.descripcion NOT IN ('Cancelado','Finalizado')");
                $consulta->bindValue(':sector', $sector, PDO::PARAM_STR);
                break;
        }
        
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Pedido");
        return $resultado; 
    }
  
    public static function ListarCancelados(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT p.codigo, ep.descripcion as estado, p.id_mesa as mesa, 
                                                        me.nombre as descripcion, p.id_menu, te.descripcion as sector, p.nombre_cliente,
                                                        em.nombre_empleado as nombre_mozo, p.id_mozo, p.id_encargado, p.hora_inicial, p.hora_entrega_estimada,
                                                        p.hora_entrega_real, p.fecha
                                                        FROM pedido p
                                                        INNER JOIN estado_pedidos ep ON ep.id_estado_pedidos = p.id_estado_pedidos
                                                        INNER JOIN menu me ON me.id = p.id_menu
                                                        INNER JOIN tipoempleado te ON te.id_tipo_empleado = me.id_sector 
                                                        INNER JOIN empleado em ON em.ID_empleado = p.id_mozo
                                                        WHERE ep.descripcion = 'Cancelado'");
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Pedido");
        return $resultado; 
    }


    //tiempoRestante($codigoPedido)

    //MasVendido

    //MenosVendido

    //ListarFueraDelTiempoEstipulado

    //Listar 
}
?>