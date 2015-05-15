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
}
