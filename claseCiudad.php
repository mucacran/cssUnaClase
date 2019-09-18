<?php
class claseCiudad extends claseWindowMantenimiento
{
    public function consulta()
    {
        return "Aqui estoy";
    }
    public function getDato()
    {
        $clase = get_class();
        
        $this->setTabla("ciudad");
        $this->setCodigo("codigo");
        $this->setOrden("codigo");
        $code = parent::getPage($clase);
        
        return $code;
    }
    
    public function getCode()
    {
        
        $dato = $this->getDato();
        $code = "
			<h1>
				Mantenimiento de Ciudad
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