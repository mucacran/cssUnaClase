function ajax(form, url) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.responseType = 'text';
	xmlhttp.onload = function(e) {
		if (this.readyState == 4 && this.status == 200) {
			var resultado = this.response;
			if (resultado.indexOf('[EJECUTAR]') >= 0) {
				var form = new FormData();
				form.append('sessionName', resultado.split(",")[2]);
				form.append('accion', resultado.split(",")[1]);
				form.append('control', 'contenedor');
				ejecutar(form);
				return;
			} else if (resultado.indexOf('[ERROR]') >= 0) {
				document.getElementById('mensaje').innerHTML = resultado;
				return;
			} else if (resultado.indexOf('[OK]') >= 0) {
				window.location = './menu.php';
			} else {
				document.getElementById('mensaje').innerHTML = resultado;
				return;
			}

		}
	}
	xmlhttp.open('POST', url, true);
	xmlhttp.send(form);
}
function onclickAcceso(sesion) {
	var form = new FormData();
	form.append("sessionName", sesion);
	form.append('accion', "validarLogin");
	form.append('txtusuario', document.getElementById('txtusuario').value);
	form.append('txtclave', document.getElementById('txtclave').value);
	form.append('ejecutar', "menu");
	ajax(form, 'controlador.php');
}

function formulario(form) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function(e) {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('formulario').innerHTML = this.response;
			return;
		}
	}
	xmlhttp.open("POST", "controlador.php", true);
	xmlhttp.send(form);

}

function ejecutar(form) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function(e) {
		if (this.readyState == 4 && this.status == 200) {
			var control = form.get('control');
			document.getElementById(control).innerHTML = this.response;
			return;
		}
	}
	xmlhttp.open("POST", "controlador.php", true);
	xmlhttp.send(form);

}

function opcion(id, pagina, sesion) {
	var form = new FormData();
	form.append("sessionName", sesion);
	form.append("accion", "opcion");
	form.append("codigo", id);
	form.append("pagina", pagina);
	form.append("control", "formulario");
	ejecutar(form);

}

function submenu(id, sesion) {
	var form = new FormData();
	form.append("sessionName", sesion);
	form.append("accion", "submenu");
	form.append("codigo", id);
	form.append("control", "sm" + id);
	ejecutar(form);
}
function habilitar(valor) {
	document.getElementById('nuevo').disabled = valor;
	document.getElementById('modificar').disabled = valor;
	document.getElementById('eliminar').disabled = valor;
	document.getElementById('consultar').disabled = valor;
	document.getElementById('grabar').disabled = !valor;
	document.getElementById('cancelar').disabled = !valor;
}
function ejecutarBoton(id) {
	var operacion = document.getElementById('operacion').value;

	document.getElementById('operacion').value = id;
	if (id == 'nuevo') {
		habilitar(true);

		document.getElementById('codigo').value = '';
		document.getElementById('descripcion').value = '';

	} else if (id == 'modificar') {
		habilitar(true);
	} else if (id == 'eliminar') {
		habilitar(true);
	} else if (id == 'consultar') {
		habilitar(true);
	} else if (id == 'grabar') {
		if (operacion == 'nuevo') {
			var form = document.getElementById('forma');
			var formData = new FormData(form);

			formData.append("accion", "mantenimiento");
			formData.append("metodo", "nuevo");
			formData.append("control", "mensaje");

			ejecutar(formData);

			habilitar(false);

		}
	} else if (id == 'cancelar') {
		habilitar(false);
	}
}
function paginacion(pagina, clase, sesion) {
	var formData = new FormData();
	formData.append("sessionName", sesion);
	formData.append("accion", "mantenimiento");
	formData.append("clase", clase);
	formData.append("metodo", "getDato");
	formData.append("numeropagina", pagina);
	formData.append("control", "detalle");

	ejecutar(formData)
}
function mantenimiento(form) {
	var enontro = false;
	if (form.get("metodo") != 'nuevo') {
		var ele = document.getElementsByName('seleccionarDetalle');
		var linea = ele[0];
		for (i = 0; i < ele.length; i++) {
			if (ele[i].checked) {
				linea = ele[i];
				form.append('valor', linea.value);
				enontro = true;
				break;
			}
		}
	} else {
		enontro = true;
	}
	if (enontro) {
		var nav = document.createElement('NAV');
		nav.id = 'navConsulta';
		nav.className = 'background';

		var nodo = document.getElementById('formulario');
		nodo.appendChild(nav);

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onload = function(e) {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('navConsulta').innerHTML = this.response;
				return;
			}
		}
		xmlhttp.open("POST", "controlador.php", true);
		xmlhttp.send(form);
	} else
		alert('Seleccione un registro');
}
function eliminar(url) {
	var ob = document.getElementById('objeto');
	ob.data = url;
}

function grabarCurso(form)
{
    

	
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function(e) {
		if (this.readyState == 4 && this.status == 200) {
			alert(this.response);
			return;
		}
	}
	xmlhttp.open("POST", "controlador.php", true);
	xmlhttp.send(form);
	
}