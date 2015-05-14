var con;

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
	
	function puntuar(valor,id)
	{
		conexion();
		con.onreadystatechange = respuestapuntuar;
		con.open("GET", "index.php?accion=P&id="+id+"&p="+valor+"&variable=" + Math.random(), true);
		con.send(null);
	}
	
	function respuestapuntuar()
	{
		if (con.readyState == 4)
		{
			if (con.status == 200)
			{
				document.getElementById("valoracion").innerHTML = con.responseText;
				mostrarPuntuacio(document.getElementById("valoracion").innerHTML);
			}
		}
	}
	
function mostrarPuntuacio(valor)
{
	document.getElementById("valoracion").style.width = valor+"px";
}