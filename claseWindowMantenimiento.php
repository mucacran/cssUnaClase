<?php

class claseWindowMantenimiento
{

    protected $titulo;

    /* inicio paginacion */
    protected $tabla;

    protected $codigo;

    protected $numeroFila;

    protected $orden;

    protected $condicion;

    protected $join;

    protected $claseForm;

    protected $clase;

    /* fin paginacion */
    public function __construct()
    {
        $this->numeroFila = 5;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setClase($clase)
    {
        $this->clase = $clase;
    }

    /* inicio paginacion */
    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setNumeroFila($numeroFila)
    {
        $this->numeroFila = $numeroFila;
    }

    public function setOrden($field)
    {
        if ($this->orden == null)
            $indice = 0;
        else
            $indice = count($this->orden);
        $this->orden[$indice] = $field;
    }

    public function setCondicion($condicion)
    {
        if ($this->condicion == null)
            $indice = 0;
        else
            $indice = count($this->condicion);
        $this->condicion[$indice] = $condicion;
    }

    public function getTabla()
    {
        return $this->tabla;
    }

    public function getClase()
    {
        return $this->clase;
    }

    public function setJoin($join)
    {
        if ($this->join == null)
            $indice = 0;
        else
            $indice = count($this->join);
        $this->join[$indice] = $join;
    }

    public function getJoin()
    {
        $code = "";
        for ($i = 0; $i < count($this->join); $i ++) {
            $code .= $this->join[$i] . " ";
        }
        return $code;
    }

    public function getCondicion()
    {
        $code = "";
        if (count($this->condicion) > 0)
            $code .= " WHERE ";

        for ($i = 0; $i < count($this->condicion); $i ++) {
            $code .= $this->condicion[$i] . " ";
        }
        return $code;
    }

    public function getOrden()
    {
        $code = "";
        if (count($this->orden) > 0)
            $code .= " ORDER BY ";
        for ($i = 0; $i < count($this->orden); $i ++) {
            $code .= $this->orden[$i] . " ";
        }
        return $code;
    }

    public function getPage()
    {
        $sesion = $_REQUEST['sessionName'];
        // $clase = $_REQUEST['clase'];
        $NUM_ITEMS_BY_PAGE = $this->numeroFila;

        $sql = "select cantidad, '[OK]' Mensaje from (select count(1) cantidad from " . $this->tabla . ") a";
        $db = new db();
        $arreglo = $db->devuelveArreglo($sql);
        if ($arreglo[0]['Mensaje'] != "[OK]") {
            $num_total_rows = 0;
            $code = $arreglo[0]['Mensaje'];
        } else {
            $num_total_rows = $arreglo[0]['cantidad'];

            if ($num_total_rows > 0) {
                // examino la pagina a mostrar y el inicio del registro a mostrar
                if (isset($_REQUEST['numeropagina'])) {
                    $page = $_REQUEST['numeropagina'];
                } else {
                    $page = 0;
                }

                $start = ($page - 1) * $NUM_ITEMS_BY_PAGE;
                if ($start < 0)
                    $start = 0;

                // calculo el total de paginas
                if ($num_total_rows > 0)
                    $total_pages = ceil($num_total_rows / $NUM_ITEMS_BY_PAGE);
                else
                    $total_pages = 1;

                $join = $this->getJoin();
                $where = $this->getCondicion();
                $orden = $this->getOrden();

                $sql = "SELECT a.*, '[OK]' as Mensaje FROM " . $this->tabla . " a " . $join . " " . $where . " " . $orden . "  LIMIT " . $start . ", " . $NUM_ITEMS_BY_PAGE;

                $db = new db();
                $arreglo = $db->devuelveArreglo($sql);

                if ($arreglo[0]["Mensaje"] != '[OK]') {
                    $code = $arreglo[0]["Mensaje"];
                } else {
                    // $code = $arreglo[0]["Mensaje"];
                    $code = "";
                    if (count($arreglo) > 0) {
                        $code .= "<nav id='detalle'>";
                        $code .= "<nav style='justify-content: center;display: flex;'>";
                        $code .= "<form><fildset>";
                        $code .= "<table border='1'>";
                        $code .= "<tr>";

                        $titulo = $arreglo[0];
                        $code .= "<td><h3>Seleccionar</h3></td>";

                        foreach ($titulo as $key => $value) {
                            if ($key != "Mensaje")
                                $code .= "<td><h3>" . $key . "</h3></td>";
                        }

                        $code .= "</tr>";

                        for ($i = 0; $i < count($arreglo); $i ++) {

                            $row = $arreglo[$i];

                            $code .= "<tr>";
                            $code .= "<td><input type='radio' name='seleccionarDetalle' id='seleccionarDetalle' value=" . $row[$this->codigo] . "></td>";
                            foreach ($row as $key => $value) {
                                if ($key != "Mensaje")
                                    $code .= "<td>" . $value . "</td>";
                            }

                            $code .= "</tr>";
                        }
                        $code .= "</table>";
                        $code .= "</fildset></form>";
                    }
                    $code .= "</nav>";
                    $code .= "<nav id='paginacion' style='justify-content: center;display: flex;'>";

                    if ($total_pages > 1) {
                        for ($i = 1; $i <= $total_pages; $i ++) {
                            if ($page == $i) {
                                $code .= "<button onclick='paginacion($page,\"" . $this->getClase() . "\",\"$sesion\");'>$page</button>";
                            } else {
                                $code .= "<button onclick='paginacion($i,\"" . $this->getClase() . "\",\"$sesion\");'>$i </button>";
                            }
                        }
                    }
                    $code .= "</nav>";

                    $codigo = $this->codigo;

                    $code .= "
                            <nav style='justify-content: center;display: flex;'>
                             <input type='button' value='Agregar' onclick='
                             
                                var form = new FormData();
                            	form.append(\"accion\",\"mantenimiento\");
                            	form.append(\"clase\",\"" . $this->getClase() . "\");
                            	form.append(\"metodo\",\"nuevo\");
                            	form.append(\"sessionName\",\"$sesion\");
                            	form.append(\"campo\",\"$codigo\");
                                mantenimiento(form);'>
                             <input type='button' value='Modificar' onclick='
                             
                                var form = new FormData();
                            	form.append(\"accion\",\"mantenimiento\");
                            	form.append(\"clase\",\"" . $this->getClase() . "\");
                            	form.append(\"metodo\",\"modifica\");
                            	form.append(\"sessionName\",\"$sesion\");
                            	form.append(\"campo\",\"$codigo\");
                                mantenimiento(form);'>
                             <input type='button' value='Elimnar' onclick='
                             
                                var form = new FormData();
                            	form.append(\"accion\",\"mantenimiento\");
                            	form.append(\"clase\",\"" . $this->getClase() . "\");
                            	form.append(\"metodo\",\"elimina\");
                            	form.append(\"sessionName\",\"$sesion\");
                            	form.append(\"campo\",\"$codigo\");
                                mantenimiento(form);'>
                             <input type='button' value='Consultar' onclick='
                             
                                var form = new FormData();
                            	form.append(\"accion\",\"mantenimiento\");
                            	form.append(\"clase\",\"" . $this->getClase() . "\");
                            	form.append(\"metodo\",\"consulta\");
                            	form.append(\"sessionName\",\"$sesion\");
                            	form.append(\"campo\",\"$codigo\");
                                mantenimiento(form);'>
                            </nav>
                        ";
                    $code .= "</nav>";
                }
            }
        }
        return $code;
    }

    /* fin paginacion */
    public function show()
    {
        $code = "";
        return $code;
    }
}
?>