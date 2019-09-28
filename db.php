<?php

class base
{
    protected  $dbms="";
    protected $servidor="";
    protected $usuario="";
    protected $clave="";
    protected $baseDato="";
    protected $puerto="";
	public $coneccion="";

	public function __construct()
	{
		$file="parametro.ini";
		$gestor=fopen($file, "r"); //Abre el archivo en modo lectura, ecsritura para añadir al final del archivo
		$texto=fread($gestor, filesize($file));
		fclose($gestor);


		$datos = explode(";", $texto);

		$dato  = explode("=", $datos[0]);
		$this->servidor=$dato[1];
		$dato  = explode("=", $datos[1]);
		$this->usuario=$dato[1];
		$dato  = explode("=", $datos[2]);
		$this->clave=$dato[1];
		$dato  = explode("=", $datos[3]);
		$this->baseDato=$dato[1];
		$dato  = explode("=", $datos[4]);
		$this->puerto=$dato[1];
		$dato  = explode("=", $datos[5]);
		$this->dmbs=$dato[1];
		
		include_once($this->dmbs.".php");

		$this->coneccion=0;
	}
}
$base = new base();
unset($base);
?>