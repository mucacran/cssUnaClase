<?php

class db extends base
{

    public function conectar(&$mensaje)
    {
        if (! $this->coneccion) {
            $db = new mysqli($this->servidor, $this->usuario, $this->clave, $this->baseDato, $this->puerto);
            if ($db->connect_errno) {
                $mensaje = "[ERROR] Error al conectar a la base de datos";
                return false;
            }
            $this->coneccion = $db;
        }
        return $this->coneccion;
    }

    public function ejecutar($sql, &$mensaje)
    {
        $texto =true;
        $mensaje="OK";
        if (! $this->conectar($mensaje)) {
            $$texto = $mensaje;
        } else {
            $db = $this->coneccion;

            try {
                $resultado = $db->query($sql);
                if (! $resultado) {
                    $mensaje = "[ERROR] " . $db->error;
                    $texto = false;
                } 
            } catch (Exception $e) {
                $mensaje = $e->error();
            }
        }
        return $texto;
    }

    public function devuelveArreglo($sql)
    {
        $mensaje = "";
        if (! $this->conectar($mensaje)) {
            $arreglo = array(
                0 => array(
                    "Mensaje" => $mensaje
                )
            );
        } else {
            $mensaje = "";
            $db = $this->coneccion;
            $resultado = $db->query($sql);
            if (! $resultado) {
                $mensaje = "[ERROR] " . $db->error;
                $arreglo = array(
                    0 => array(
                        "Mensaje" => $mensaje
                    )
                );
            } else {
                $arreglo = array();
                while ($dato = mysqli_fetch_assoc($resultado)) {
                    $arreglo[count($arreglo)] = $dato;
                }
            }
        }
        return $arreglo;
    }
}
?>