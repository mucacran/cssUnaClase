<?php
header("Content-Type: text/html; charset=ISO-8859-1");

include_once ("db.php"); // Incye libreria que cnecta a la base de datos
include_once ("claseLogin.php"); // Incuye case que permite mostrar y validar el login
include_once ("claseWindowMantenimiento.php");
$carpeta = "itsg";

if (! isset($_REQUEST['sessionName'])) // Verifica que existe variable accion de no existir significa que nunca a iniciado sesion.
{
    $sesion = "sn" . rand();
    session_name($sesion);
    session_start();

    $_SESSION['login'] = 'NO';
    $_SESSION['autenticado'] = 'NO';
    $_SESSION['sessionName'] = $sesion;

    header("Location: http://localhost/$carpeta/controlador.php?sessionName=$sesion&accion=login");
    return false;
} else {
    /*
     * Una vez que el sistema a mostrador el login, por esta condicion controla las acciones que pide ejecutar el usuario
     */
    $sesion = $_REQUEST['sessionName'];
    $accion = $_REQUEST['accion'];

    session_name($sesion);
    session_start();
    $code = "";

    if ($accion == "login" && $_SESSION['autenticado'] == 'NO') {
        $login = new claseLogin(); // Instancia la clase login`
        $code .= "<object type='text/html' data='http://localhost/$carpeta/controlador.php?sessionName=$sesion&accion=login' width='100%' height='100%'>";
        $code .= $login->getCode(); // Obtiene el codigo para mostrar el login
        $code .= "</object>";
    } elseif ($accion == "validarLogin" && $_SESSION['login'] == 'SI') {
        $login = new claseLogin();
        $code = $login->validarLogin();
    } elseif ($accion == "menu" && $_SESSION['autenticado'] == 'SI') {
        $login = new claseLogin();
        $code .= $login->menu();
    } elseif ($accion == "login" && $_SESSION['autenticado'] == 'SI') {
        $login = new claseLogin();
        $cod = $login->menu();
        $code = "<nav id='contenedor' class='contenedor'>" . $cod . "</nav>";
    } elseif ($accion == "submenu") {
        $login = new claseLogin();
        $code = $login->submenu();
    } elseif ($accion == "grabar") {
        $clase = $_REQUEST['clase'];
        $metodo = $_REQUEST['metodo'];
        
        include_once ("$clase.php");
        $objeto = new $clase();
        $code = $objeto->$metodo();
    } elseif ($accion == "opcion") {
        $pagina = $_REQUEST['pagina'];
        if ($pagina != "") {
            if (file_exists("$pagina.php")) {
                include_once ("$pagina.php");
                $objeto = new $pagina();
                $code = $objeto->getCode();
            } else
                $code = '';
        } else
            $code = '';
    } elseif ($accion == 'mantenimiento') {

        $clase = $_REQUEST['clase'];
        $metodo = $_REQUEST['metodo'];

        include_once ("$clase.php");
        $objeto = new $clase();
        $code = $objeto->$metodo();
    }
}
echo $code;
?>