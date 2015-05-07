<?php
    function leerfichero($nombre)
    {
        $cadena = fread(fopen($nombre, "r"), filesize($nombre));
        return $cadena;
    }

    function vmostrarLogin()
    {
        $aux = leerfichero("fonts/login.html");
        $partes = explode("##INVITADO##", $aux);
        echo $partes[0] . $partes[1];
    }
    
    function vmostrarUsuario($user)
    {
        $aux = leerfichero("fonts/login.html");
        $partes = explode("##INVITADO##", $aux);
		$partes[2] = str_replace("##USER##", $user, $partes[2]);
        echo $partes[0] . $partes[2];
    }
	
	function vmostrarPreferencias()
    {
        $aux = leerfichero("fonts/preferencias.html");
        echo $aux;
    }
	
	function vmostrarCambiocontraseña()
	{
		$aux = leerfichero("fonts/prefcontraseina.html");
        echo $aux;
	}
	
	function vmostrarCambiocorreo()
	{
		$aux = leerfichero("fonts/prefemail.html");
        echo $aux;
	}
	
	function vmostrarEliminarcuenta()
	{
		$aux = leerfichero("fonts/prefeliminar.html");
        echo $aux;
	}
	
	function vmostrarRecuperar()
	{
		$aux = leerfichero("fonts/recuperar.html");
		echo $aux;
	}
	
	function vmostrarRegistro()
	{
		$aux = leerfichero("fonts/alta.html");
		echo $aux;
	}
	
	function vmostrarBuscardor()
	{
		$aux = leerfichero("fonts/buscar.html");
		echo $aux;
	}
    
    function vmostrarImenu()
    {
        $aux = leerfichero("fonts/menu.html");
        $partes = explode("##REGISTRADO##", $aux);
        echo $partes[0] . $partes[2];
    }

    function vmostrarRmenu()
    {
        $aux = leerfichero("fonts/menu.html");
        $partes = explode("##REGISTRADO##", $aux);
        echo $partes[0] . $partes[1] . $partes[2];
    }

    function vmostrarToplistas($consulta)
    {
        $aux = leerfichero("fonts/toplistas.html");
        $partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##NOMBRE##", $datos["Titulo"], $lista);
			$lista = str_replace("##ASUNTO##", $datos["Asunto"], $lista);
			$lista = str_replace("##N##", $datos["Canciones"], $lista);
			$lista = str_replace("##AUTOR##", $datos["Usuario"], $lista);
			$lista = str_replace("##VALORACION##", $datos["ValoracionSemanal"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
    }
    
    function vmostrarTopcanciones($consulta)
    {
		$aux = leerfichero("fonts/topcanciones.html");
        $partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##TITULO##", $datos["Titulo"], $lista);
			$lista = str_replace("##AUTOR##", $datos["Autor"], $lista);
			$lista = str_replace("##N##", $datos[3], $lista);
			$lista = str_replace("##ALBUM##", $datos["Album"], $lista);
			$lista = str_replace("##VALORACION##", $datos["ValoracionSemanal"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
    }
	
	function vmostrarMislistas($consulta)
	{
		$aux = leerfichero("fonts/mislistas.html");
        $partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##NOMBRE##", $datos["Nombre"], $lista);
			$lista = str_replace("##ASUNTO##", $datos["Asunto"], $lista);
			$lista = str_replace("##N##", $datos[6], $lista);
			$lista = str_replace("##AUTOR##", $datos["Autor"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
	}
	
	function vmostrarMisfavoritos($consulta)
	{
		$aux = leerfichero("fonts/misfavoritos.html");
        $partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##TITULO##", $datos["Titulo"], $lista);
			$lista = str_replace("##Autor##", $datos["Autor"], $lista);
			$lista = str_replace("##N##", $datos[3], $lista);
			$lista = str_replace("##ALBUM##", $datos["Album"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
	}
	
	function vmostrarContactar()
	{
		$aux = leerfichero("fonts/contactar.html");
		echo $aux;
	}
	function vmostrarContacto()
	{
		$aux = leerfichero("fonts/contacto.html");
		echo $aux;
	}
	
	function valtacancion(){
            $aux=  leerfichero('admin/altacancion.html');
            echo $aux;
        }
	/////////////////////////////////////////////////////////////
	function vloginadmin(){
		$aux=  leerfichero('admin/adminlogin.html');
		echo $aux;
	}
	function vmostrarAmenu(){
		$aux=  leerfichero('admin/menu.html');
		echo $aux;
	}
	function vbuscarborrar($buscar="",$tipo=1){
		$aux=leerfichero('admin/buscar.html');
		$aux =str_replace("##BUSCAR##", $buscar, $aux);
		switch ($tipo){ //1 titulo, 2 autor 3 disco
			case 1:$aux=str_replace("##TCHK##", 'checked', $aux);
				break;
			case 2:$aux=str_replace("##ACHK##", 'checked', $aux);
				break;
			case 3:$aux=str_replace("##DCHK##", 'checked', $aux);
				break;
		}
		//limpiamos marcas
		$aux=str_replace("##TCHK##", '', $aux);
		$aux=str_replace("##ACHK##", '', $aux);
		$aux=str_replace("##DCHK##", '', $aux); 
		echo $aux;
	}
	function vcancionesborrar($canciones){
		$aux = leerfichero("admin/canciones.html");
		$partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		if ($canciones!=null){
			foreach ($canciones as $cancion) {
				$lista = $partes[1];
				$lista = str_replace("##TITULO##", $cancion['Titulo'], $lista);
				$lista = str_replace("##AUTOR##", $cancion['Autor'], $lista);
				$lista = str_replace("##ALBUM##", $cancion['Album'], $lista);
				$lista = str_replace("##GENERO##",$cancion['Genero'], $lista);
				$lista = str_replace("##AÑO##", $cancion['Año'], $lista);
				$lista = str_replace("##IDCANCION##", $cancion['Id'], $lista);
				$contenido .= $lista;
			}

			echo $partes[0] . $contenido . $partes[2];
		}else{
			echo "<p> No se han encontrado canciones con ese criterio</p>";
		}
	}
?>