<?php

class claseLogin
{

    public function submenu()
    {
        $sesion=$_SESSION['sessionName'];
        $mensaje = "";
        $db = new db();
        $db->conectar($mensaje);

        if (! $db->coneccion) {
            return $mensaje;
        }

        $sql = "call spc_menu(".$_REQUEST['codigo'].")";

        $arreglo = $db->devuelveArreglo($sql, $mensaje);

        $menu = "";
        for ($i = 0; $i < count($arreglo); $i ++) {

            $codigo = $arreglo[$i]["codigo"];
            $descripcion = $arreglo[$i]["descripcion"];
            $pagina = $arreglo[$i]["pagina"];

            $pagina = $arreglo[$i]["pagina"];

            if (is_null($pagina))
                $pagina = '' ;

            if ($arreglo[$i]["tipo"] == "0") {
                $menu.= "<li><a id=$codigo  onmouseover='submenu(this.id,\"$sesion\");'>" . $descripcion . "</a>";
                $menu.= "<ul id='sm$codigo'></ul></li>";
            } else {
                $menu.= "<li><a id=$codigo  onclick='opcion(this.id,\"$pagina\",\"$sesion\");'>". $descripcion . "</a></li>";
            }
        }
        return $menu;
    }

    public function menu()
    {
        $sesion=$_SESSION['sessionName'];
        $mensaje = "";

        $db = new db();
        $db->conectar($mensaje);

        if (! $db->coneccion) {
            return $mensaje;
        }

        $sql = "call spc_menu(0)";

        $arreglo = $db->devuelveArreglo($sql, $mensaje);

        $menu = "
            <ul>";
        for ($i = 0; $i < count($arreglo); $i ++) {

            $codigo = $arreglo[$i]["codigo"];
            $descripcion = $arreglo[$i]["descripcion"];

            $pagina = $arreglo[$i]["pagina"];

            if (is_null($pagina))
                $pagina = '' ;

            if ($arreglo[$i]["tipo"] == "0") {
                $menu .= "<li><a id=$codigo  onmouseover='submenu(this.id,\"$sesion\");'>" . $descripcion . "</a>";
                $menu .= "<ul id='sm$codigo'></ul></li>";
            } else {
                $menu .= "<li><a id=$codigo  onclick='opcion(this.id,\"$pagina\",\"$sesion\");'>". $descripcion . "</a></li>";
            }
        }
        $menu .= "</ul>";

        $code = "
            <!DOCTYPE html>
            <html>
            	<head>
            		<title>Menú</title>
            		<link rel='stylesheet' type='text/css' href='claseLogin.css'>
                    <script src='funciones.js'></script>
            	</head>
            	<body>
                    <nav class='background'>
                         <nav class='backgroundImage'>
                         </nav>
                    </nav>
                   
            		<nav class='menu'>
            			$menu
            		</nav>
                    <nav id='formulario' class='formulario'>
                    </nav>
            	</body>
            </html>
        ";
        return $code;
    }

    public function validarLogin()
    {
        if (! isset($_POST['txtusuario']) || ! isset($_POST['txtclave'])) {
            $code = "[ERROR] Acceso no autorizado.";
            return $code;
        }
        $sesion=$_SESSION['sessionName'];
        
        $mensaje = "";

        $db = new db();
        $db->conectar($mensaje);

        if (! $db->coneccion) {
            return $mensaje;
        }

        $usuario = $_POST['txtusuario'];
        $clave = $_POST['txtclave'];

        $sql = "select nombre, clave, estado from usuario where usuario='" . $usuario . "'";

        $texto = $db->devuelveArreglo($sql, $mensaje);
        if (count($texto)>0) {
            $dato = $texto[0];
            if ($dato["estado"] == 1) {
                if ($dato["clave"] == $clave) {
                    if (isset($_POST['ejecutar'])) {
                        $code = "[EJECUTAR]," . $_POST['ejecutar'].",".$sesion;
                    } else {
                        $code = "[OK],Inicio de sesiÃ³n correcto," . $dato[0].",".$sesion;
                    }
                    $_SESSION['autenticado']="SI";
                    return $code;
                } else {
                    $code = "[ERROR] Clave incorrecta";
                    return $code;
                }
            } else {
                $code = "[ERROR] Usuario inactivo";
                return $code;
            }
        } else {
            return $mensaje;
        }
    }

    public function getCode()
    {
        $sesion=$_REQUEST['sessionName'];
        $_SESSION['login']="SI";
        $code = "
				<!DOCTYPE html>
				<html>
				<head>
					<title>Login</title>
                    <link rel='stylesheet' type='text/css' href='claseLogin.css'>
					<script src='funciones.js'></script>
				</head>
				<body>
					<nav class='contenedor' id='contenedor'>
                        <nav class='login'>
						<table>
							<tr>
								<td>
									<label>
										Usuario
									</label>
								</td>
								<td>
									<input type='text' id='txtusuario'>
								</td>
							</tr>
							<tr>
								<td>
									<label>
										Clave
									</label>
								</td>
								<td>
									<input type='password' id='txtclave'>
								</td>
							</tr>
							<tr>
								<td colspan='2' align='center'>
									<input type='button' id='btnacceso' value='Accesar'
										onclick='
											onclickAcceso(\"$sesion\");
										'
									>
								</td>
							</tr>
							<tr>
								<td id='mensaje' colspan='2'>
									
								</td>
							</tr>
						</table>
                        </nav>
					</nav>	
				</body>
				</html>
			";
        return $code;
    }
}
?>