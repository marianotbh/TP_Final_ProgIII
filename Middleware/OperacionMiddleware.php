<?php
class OperacionMiddleware
{
    ///Suma una operación al empleado.
    public static function SumarOperacionAEmpleado($request, $response, $next)
    {
        $payload = $request->getAttribute("payload")["Payload"];

        Empleado::SumarOperacion($payload->id);

        return $next($request, $response);
    }
}
?>