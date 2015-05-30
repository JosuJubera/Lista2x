var con;
var idG;

	function conexion()
	{
		if (window.ActiveXObject)
		{
			con = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
			if (window.XMLHttpRequest)
			{
				con = new XMLHttpRequest();
			}
		}
	}
	
	function puntuar(valor,id,tipo)
	{
		conexion();
		idG = id;

		con.onreadystatechange = respuestapuntuar;
		con.open("GET", "index.php?accion=P"+tipo+"&id="+id+"&p="+valor+"&variable=" + Math.random(), true);
		con.send(null);
	}
	
	function respuestapuntuar()
	{
		if (con.readyState == 4)
		{
			if (con.status == 200)
			{
				if (con.responseText == -1)
				{
					mostrarPuntuacion(document.getElementById("valoracion-"+idG).innerHTML,idG);
				}
				else
				{
					document.getElementById("valoracion-"+idG).innerHTML = con.responseText;
					mostrarPuntuacion(document.getElementById("valoracion-"+idG).innerHTML, idG);
				}
			}
		}
	}
	
function mostrarPuntuacion(valor,id)
{
	document.getElementById("valoracion-"+id).style.width = valor+"px";
	mostrarMensaje("Se ha actualizado correctamente la valoración", "exito");
}

function mostrarMensaje(mensaje,tipo)
{
	document.getElementById(tipo+" mensajes").style.visibility = "visible";
	document.getElementById(tipo+" mensajes").innerHTML = mensaje;
	setTimeout(function(){ document.getElementById(tipo+" mensajes").style.visibility = "hidden"; }, 3000);
}

function comprobarBuscar()
{
	if ((document.getElementById("search").value == "") || (document.getElementById("search").value == "buscar"))
	{
		mostrarMensaje("Introduce la busqueda", "alerta");
	}
	else
	{
		document.forms["buscar"].submit();
	}
}

function comprobarUser(tipo)
 {
 	if (tipo == 'user') // Comprobar si la sesion es de usuario
 	{
 		var url = window.location.href;
 		var n = url.indexOf("index");
 		var m = url.substring(0,n);
 		var res = m.concat("index.php?accion=TL&id=1");
 		window.location.assign(res);
 	}
 	
 	if (tipo == 'admin') // Comprobar si la sesion es de administrador
 	{
 		var url = window.location.href;
 		var n = url.indexOf("index");
 		var m = url.substring(0,n);
 		var res = m.concat("index.php?accion=AR&id=1");
 		window.location.assign(res);
 	}
 }

function cargarPagina(pag,pid){ //falta por terminar
    $.ajax({
    url : 'index.php',
    data :'accion=VP&id=2&pid='+pid+'&pag='+pag,
    type : 'GET',
    // código a ejecutar si la petición es satisfactoria;
    // la respuesta es pasada como argumento a la función
    success : function(res) {
                document.getElementById("comentarios").innerHTML = res;
            }
    });
}
function añadirCancionPlaylist(){
    var pid=$('#cidselect').val();
    var cid=$('#pidenviar').val();
    $.ajax({
        url: 'index.php',
        data: 'accion=MODL&id=3&pid='+pid+'&cid='+cid,
        type: 'GET',
        succes: function(res){
            if (parseInt(res)===1){//exito
                //mostrarMensaje("Cancion añadida con exito", "alerta");
                alert('exito');
            }else{//fallo
                //mostrarMensaje("Error, la cancion ya esta en la lista","alerta");
                alert('fallo');
            }
        }   
    });
}