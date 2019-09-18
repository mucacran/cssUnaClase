<?php

class claseMateria extends claseWindowMantenimiento
{

    public function nuevo()
    {
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
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        
        $sql = "select a.*, '[OK]' Mensaje from curso a where $campo='$valor'";
        
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        
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
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        
        $sql = "select a.*, '[OK]' Mensaje from curso a where $campo='$valor'";
        
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        
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
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        
        $sql = "select a.*, '[OK]' Mensaje from  curso a where $campo='$valor'";
        
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
        $clase = get_class();
        
        $this->setTabla("materia");
        $this->setCodigo("codigo");
        $code = parent::getPage($clase);
        
      
        return $code;
    }

    public function getCode()
    {
        
        $dato = $this->getDato();
        $code = "
			<h1>
				Mantenimiento de Materia
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