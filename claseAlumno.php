<?php

class claseAlumno extends claseWindowMantenimiento
{

    public function nuevo()
    {
        $this->setClase(get_class());
        
        $campo = $_REQUEST['campo'];        
        
        $code = "
            <button onclick='
                var node = document.getElementById(\"navConsulta\");
                var padre = node.parentNode;
                padre.removeChild(node);
            '>Cerrar</button>
        ";
        
        return $code;
    }
    public function modifica()
    {
        $this->setClase(get_class());
        
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        
        $sql = "select a.*, '[OK]' Mensaje from alumno a where $campo='$valor'";
        
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        
        // var_dump($linea);
        $code = "<table>";
        foreach ($linea as $key => $valor) {
            if ($key != 'Mensaje') {
                $code .= "<tr><td>$key</td>";
                $code .= "<td>$valor</td></tr>";
            }
        }
        $code .= "</table>";
        $code .= "
            <button onclick='
                var node = document.getElementById(\"navConsulta\");
                var padre = node.parentNode;
                padre.removeChild(node);
            '>Cerrar</button>
        ";
        
        return $code;
    }
    public function elimina()
    {
        $this->setClase(get_class());
        
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        
        $sql = "select a.*, '[OK]' Mensaje from alumno a where $campo='$valor'";
        
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        
        // var_dump($linea);
        $code = "<table>";
        foreach ($linea as $key => $valor) {
            if ($key != 'Mensaje') {
                $code .= "<tr><td>$key</td>";
                $code .= "<td>$valor</td></tr>";
            }
        }
        $code .= "</table>";
        $code .= "
            <button onclick='
                var node = document.getElementById(\"navConsulta\");
                var padre = node.parentNode;
                padre.removeChild(node);
            '>Cerrar</button>
        ";
        
        return $code;
    }
    public function consulta()
    {
        $this->setClase(get_class());
        
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        
        $sql = "select a.*, '[OK]' Mensaje from alumno a where $campo='$valor'";
        
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        
        // var_dump($linea);
        $code = "<table>";
        foreach ($linea as $key => $valor) {
            if ($key != 'Mensaje') {
                $code .= "<tr><td>$key</td>";
                $code .= "<td>$valor</td></tr>";
            }
        }
        $code .= "</table>";
        $code .= "
            <button onclick='
                var node = document.getElementById(\"navConsulta\");
                var padre = node.parentNode;
                padre.removeChild(node);
            '>Cerrar</button>
        ";
        
        return $code;
    }

    public function getDato()
    {
        $this->setClase(get_class());

        $this->setTabla("alumno");
        $this->setCodigo("cedula");
        $this->setOrden("cedula");
        $code = parent::getPage();

        return $code;
    }

    public function getCode()
    {
        $this->setClase(get_class());
        $dato = $this->getDato();
        $code = "
			<h1>
				Mantenimiento de alumno
			</h1>
			
            <nav>
                $dato
            </nav>
			<nav id='mensaje'>
			<nav>
		";
        return $code;
    }
}

?>