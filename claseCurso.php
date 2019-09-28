<?php

class claseCurso extends claseWindowMantenimiento
{

    public function nuevo()
    {
        $this->setClase(get_class());
        
        $sesion = $_REQUEST['sessionName'];
        
        $code = "<form id='frmCurso'><table>";
        $code .= "<tr><td>Código</td>";
        $code .= "<td><input type='text' name='codigo' value='' disabled></td></tr>";
        
        $code .= "<tr><td>Descripción</td>";
        $code .= "<td><input type='text'name='descripcion' value=''></td></tr>";
        $code .= "<input type='hidden' name='sessionName' value='$sesion'>";
        $code .= "</table></form>";
        $code .= "
            <button onclick='
            
                var form = new FormData(document.getElementById(\"frmCurso\"));
                form.append(\"accion\",\"grabar\");
            	form.append(\"clase\",\"".$this->getClase()."\");
            	form.append(\"metodo\",\"grabarAgregar\");
                grabarCurso(form);
            	    
            	    
            '>Grabar</button>
            <button onclick='
                var node = document.getElementById(\"navConsulta\");
                var padre = node.parentNode;
                padre.removeChild(node);
            '>Cerrar</button>
        ";
        
        return $code;
    }
    public function grabarAgregar(){
        
        $mensaje='';
        $sql = "call spi_curso ('".$_REQUEST['descripcion']."')";
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        $code=$linea['Mensaje'];
        
        return $code;
    }
    public function modifica()
    {
        $this->setClase(get_class());
        
        $campo = $_REQUEST['campo'];
        $valor = $_REQUEST['valor'];
        $sesion = $_REQUEST['sessionName'];
        
        $sql = "select a.*, '[OK]' Mensaje from curso a where $campo='$valor'";
        
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        $linea = $arreglo[0];
        
        $code = "<form id='frmCurso'><table>";
        $code .= "<tr><td>Código</td>";
        $code .= "<td><input type='text' value='".$linea['codigo']."' disabled></td></tr>";
        
        $code .= "<tr><td>Descripción</td>";
        $code .= "<td><input type='text'name='descripcion' value='".$linea['descripcion']."'></td></tr>";
        $code .= "<input type='hidden' name='sessionName' value='$sesion'>";
        $code .= "<input type='hidden' name='codigo' value='".$linea['codigo']."'>";
        $code .= "</table></form>";
        $code .= "
            <button onclick='
                
                var form = new FormData(document.getElementById(\"frmCurso\"));
                form.append(\"accion\",\"grabar\");
            	form.append(\"clase\",\"".$this->getClase()."\");
            	form.append(\"metodo\",\"grabarModificar\");
                grabarCurso(form);

               
            '>Grabar</button>
            <button onclick='
                var node = document.getElementById(\"navConsulta\");
                var padre = node.parentNode;
                padre.removeChild(node);
            '>Cerrar</button>
        ";
        
        return $code;
    }
    public function grabarModificar(){
        $mensaje='';
        $sql = "update curso set descripcion='".$_REQUEST['descripcion']."' where codigo=".$_REQUEST['codigo'];
        $db = new db();
        $ok = $db->ejecutar($sql,$mensaje);
        $code=$mensaje;
        
        return $code;
    }
    public function elimina()
    {
        $this->setClase(get_class());
        
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
        $this->setClase(get_class());
        
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
        $this->setClase(get_class());
        
        $this->setTabla("curso");
        $this->setCodigo("codigo");
        $code = parent::getPage();
        
      
        return $code;
    }

    public function getCode()
    {
        $this->setClase(get_class());
        
        $dato = $this->getDato();
        $code = "
			<h1>
				Mantenimiento de Curso
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