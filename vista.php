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
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##NOMBRE##", $datos["Nombre"], $lista);
			$lista = str_replace("##ASUNTO##", $datos["Asunto"], $lista);
			$lista = str_replace("##N##", $datos["Canciones"], $lista);
			$lista = str_replace("##USUARIO##", $datos["Usuario"], $lista);
			$lista = str_replace("##FECHA##", $datos["Fecha"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$lista = str_replace("##VALORACIONSEMANAL##", $datos["ValoracionSemanal"], $lista);
			$i++;
			$contenido .= $lista;
		}
        echo $partes[0] . $contenido . $partes[2];
    }
	
	function vmostrarBuscarlistas($buscar,$consulta)
    {
        $aux = leerfichero("fonts/buscarlista.html");
		$aux = str_replace("##BUSCAR##", $buscar, $aux);
		$partes = explode("##FILALISTA##", $aux);
        if ($consulta == null)
		{//No hay resultados
 
            $error="<p><b>No se han obtenido resultados.</b></p>";
            echo $partes[0] . $error . $partes[2];
        }
		else
		{//hay resultados, los mostramos
            $contenido = "";
            $lista = "";
            $i = 1;
            while ($datos = mysql_fetch_assoc($consulta))
			{
                $lista = $partes[1];
                $partes[0] = str_replace("##BUSCAR##", $buscar, $partes[0]);
                $lista = str_replace("##ID##", $datos["Id"], $lista);
                $lista = str_replace("##POSICION##", $i, $lista);
                $lista = str_replace("##NOMBRE##", $datos["Nombre"], $lista);
                $lista = str_replace("##ASUNTO##", $datos["Asunto"], $lista);
                $lista = str_replace("##N##", $datos["Canciones"], $lista);
                $lista = str_replace("##USUARIO##", $datos["Usuario"], $lista);
                $lista = str_replace("##FECHA##", $datos["Fecha"], $lista);
                $lista = str_replace("##VALORACION##", $datos["ValoracionSemanal"], $lista);
                $contenido .= $lista;
                $i++;
            }
            echo $partes[0] . $contenido . $partes[2];
        }
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
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##TITULO##", $datos["Titulo"], $lista);
			$lista = str_replace("##ARTISTA##", $datos["Artista"], $lista);
			$lista = str_replace("##GENERO##", $datos["Genero"], $lista);
			$lista = str_replace("##ALBUM##", $datos["Album"], $lista);
			$lista = str_replace("##AÑO##", $datos["Año"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$lista = str_replace("##VALORACIONSEMANAL##", $datos["ValoracionSemanal"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
    }
	
	function vmostrarBuscarcanciones($buscar,$consulta)
    {
		$aux = leerfichero("fonts/buscarcancion.html");
        $partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$partes[0] = str_replace("##BUSCAR##", $buscar, $partes[0]);
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##TITULO##", $datos["Titulo"], $lista);
			$lista = str_replace("##ARTISTA##", $datos["Artista"], $lista);
			$lista = str_replace("##GENERO##", $datos["Genero"], $lista);
			$lista = str_replace("##ALBUM##", $datos["Album"], $lista);
			$lista = str_replace("##AÑO##", $datos["Año"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$lista = str_replace("##VALORACIONSEMANAL##", $datos["ValoracionSemanal"], $lista);
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
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##NOMBRE##", $datos["Nombre"], $lista);
			$lista = str_replace("##ASUNTO##", $datos["Asunto"], $lista);
			$lista = str_replace("##N##", $datos["Canciones"], $lista);
			$lista = str_replace("##FECHA##", $datos["Fecha"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$lista = str_replace("##VALORACIONSEMANAL##", $datos["ValoracionSemanal"], $lista);
			$contenido .= $lista;
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
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##TITULO##", $datos["Titulo"], $lista);
			$lista = str_replace("##ARTISTA##", $datos["Artista"], $lista);
			$lista = str_replace("##GENERO##", $datos["Genero"], $lista);
			$lista = str_replace("##ALBUM##", $datos["Album"], $lista);
			$lista = str_replace("##AÑO##", $datos["Año"], $lista);
			$lista = str_replace("##VALORACION##", $datos["Valoracion"], $lista);
			$lista = str_replace("##VALORACIONSEMANAL##", $datos["ValoracionSemanal"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
	}
	
	function vmostrarCancion($cancion,$consulta2,$playlist=null)
	{
		$aux = leerfichero("fonts/cancion.html");
		$partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
                $lista = $partes[0];
                $lista = str_replace("##IDC##", $cancion["Id"], $lista);
                $lista = str_replace("##TITULO##", $cancion["Titulo"], $lista);
                $lista = str_replace("##ARTISTA##", $cancion["Artista"], $lista);
                $lista = str_replace("##GENERO##", $cancion["Genero"], $lista);
                $lista = str_replace("##ALBUM##", $cancion["Album"], $lista);
                $lista = str_replace("##AÑO##", $cancion["Año"], $lista);
                $contenido .= $lista;
		while ($datos = mysql_fetch_assoc($consulta2))
		{
			$lista = $partes[1];
			$lista = str_replace("##IDP##", $datos["Id"], $lista);
			$lista = str_replace("##POSICION##", $i, $lista);
			$lista = str_replace("##NOMBRE##", $datos["Nombre"], $lista);
			$lista = str_replace("##ASUNTO##", $datos["Asunto"], $lista);
			$lista = str_replace("##N##", $datos["Canciones"], $lista);
			$lista = str_replace("##USUARIO##", $datos["Usuario"], $lista);
			$lista = str_replace("##FECHA##", $datos["Fecha"], $lista);
			$contenido .= $lista;
			$i++;
		}
                $pagina=$contenido . $partes[2];
                $partes = explode("##OPCION##", $pagina);
                if ($playlist==null){//no hay playlist para mostrar (o no tiene o no esta registrado)
                    echo $partes[0].$partes[2];
                }else{//mostramos la playlist del usuario
                    $lista="";
                    $listacompleta="";
                    $partes2 = explode("##FILAPLAYLIST##", $partes[1]);
                    foreach ($playlist as $play){
                        $lista = $partes2[1];
                        $lista = str_replace("##PTITULO##", $play['Nombre'], $lista);
			$lista = str_replace("##PID##", $play['Id'], $lista);
                        $listacompleta .= $lista;
                    }
                    $contenido=$partes2[0].$listacompleta.$partes2[2];
                    $contenido = str_replace("##CID##", $cancion['Id'], $contenido);
                    echo $partes[0]. $contenido .$partes[2];
                }
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

	/////////////////////////////////////////////////////////////
	function vloginadmin(){
		$aux=  leerfichero('admin/adminlogin.html');
		echo $aux;
	}
	function vmostrarAmenu(){
		$aux=  leerfichero('admin/menu.html');
		echo $aux;
	}
		
	function vmostrarUsuarios($consulta)
	{
		$aux=  leerfichero('admin/usuarios.html');
        $partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$lista = str_replace("##USUARIO##", $datos["Usuario"], $lista);
			$lista = str_replace("##NOMBRE##", $datos["Nombre"], $lista);
			$lista = str_replace("##APELLIDO1##", $datos["Apellido1"], $lista);
			$lista = str_replace("##APELLIDO2##", $datos["Apellido2"], $lista);
			$lista = str_replace("##CORREO##", $datos["Correo"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
	}
	
	function vmostrarCanciones($consulta)
	{
		$aux=  leerfichero('admin/canciones.html');
		$partes = explode("##FILALISTA##", $aux);
		$contenido = "";
		$lista = "";
		$i = 1;
		while ($datos = mysql_fetch_assoc($consulta))
		{
			$lista = $partes[1];
			$lista = str_replace("##ID##", $datos["Id"], $lista);
			$lista = str_replace("##TITULO##", $datos["Titulo"], $lista);
			$lista = str_replace("##ARTISTA##", $datos["Artista"], $lista);
			$lista = str_replace("##GENERO##", $datos["Genero"], $lista);
			$lista = str_replace("##ALBUM##", $datos["Album"], $lista);
			$lista = str_replace("##AÑO##", $datos["Año"], $lista);
			$contenido .= $lista;
			$i++;
		}
        echo $partes[0] . $contenido . $partes[2];
	}
	
	function valtacancion()
	{
		$aux=  leerfichero('admin/altacancion.html');
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
        function confimacionBorrar($canciones){
            if ($canciones===true){
                mostrarInfo("Se han eliminado las canciones correctamente");
                vmostrarAmenu();
            }else{
                mostrarError("Fallo a la hora de eliminar las canciones","No se han podido eliminar las canciones seleccionadas"); //TODO cambiar a un mensaje de error 
                vcancionesborrar($canciones);
            }
        }
        function mostrarError($titulo,$cuerpo){
            $aux=leerfichero('admin/error.html');
            $aux=str_replace("##TITULOERROR##", $titulo, $aux);
            $aux=str_replace("##CUERPO##", $cuerpo, $aux);
            echo $aux;
        }
        function mostrarInfo($cuerpo){
          $aux=leerfichero('admin/info.html');
           $aux=str_replace("##CUERPO##", $cuerpo, $aux);
           echo $aux;  
        }
        function vmostrarReportes($reportes){
            $aux = leerfichero("admin/reportes.html");
            $partes = explode("##FILALISTA##", $aux);
            $contenido = "";
            $lista = "";
            if ($reportes!=null){
                foreach ($reportes as $reporte) {
                        $lista = $partes[1];
                        $lista = str_replace("##USUARIO##", $reporte['Usuario'], $lista);
                        $lista = str_replace("##NREPORTES##", $reporte['Reportes'], $lista);
                        $lista = str_replace("##COMENTARIO##",$reporte['Comentario'], $lista);
                        $lista = str_replace("##ID##",$reporte['Id'], $lista);
                        $contenido .= $lista;
                }
                echo $partes[0] . $contenido . $partes[2];
            }else{
                echo "<p> No hay comentarios reportados ¡Buen trabajo!</p>";
            }
        }
        function vmostrarReportesIgnorados($ignorados){
            $aux = leerfichero("admin/reportes.html");
            $partes = explode("##FILALISTA##", $aux);
            $contenido = "";
            $lista = "";
            if ($ignorados!=null){
                foreach ($ignorados as $reporte) {
                        $lista = $partes[1];
                        $lista = str_replace("##USUARIO##", $reporte['Usuario'], $lista);
                        $lista = str_replace("##NREPORTES##", $reporte['Reportes'], $lista);
                        $lista = str_replace("##COMENTARIO##",$reporte['Comentario'], $lista);
                        $lista = str_replace("##IDCOMENTARIO##",$reporte['Id'], $lista);
                        $contenido .= $lista;
                }
                echo $partes[0] . $contenido . $partes[2];
            }else{
                echo "<p> No hay comentarios ignorados</p>";
            }
        }
        function vmostrarLista($info,$canciones,$comentarios){
            $pagina = leerfichero("fonts/playlist.html");
            //1º info de la playlist, si es null es que no existe
            if ($info==null){
                echo "<p><b>Error, no existe la playlist seleccionada</b><br/>Utilice el buscador para buscar</p>";
                return;
            }
            $pagina=str_replace("##PNOMBRE##", $info['Nombre'], $pagina);
            $pagina=str_replace("##PVALORACION##", $info['ValoracionSemanal'], $pagina);
            $pagina=str_replace("##PASUNTO##", $info['Asunto'], $pagina);
            $pagina=str_replace("##PAUTOR##", $info['Usuario'], $pagina);
            $pagina=str_replace("##PFECHA##", $info['Fecha'], $pagina);
            $pagina=str_replace("##PDESCRIPCION##", $info['Descripcion'], $pagina);
            //opciones para quitar la lista o modificarla
            $partes = explode("##OPCIONES##", $pagina);
            if (isSet($_SESSION['usuario']) && $_SESSION['usuario']==$info['Usuario']){
                $partes[1]=str_replace("##ID##", $info['Id'], $partes[1]);
                $pagina=$partes[0].$partes[1].$partes[2];
            }else{//no es el autor de la playlist
                $pagina=$partes[0].$partes[2];
            }
            //2º Canciones de la playlist, si es null es que esta vacia
            $partes = explode("##FILACANCION##", $pagina);
            if ($canciones==null){
                $error="<p>No hay canciones en esta playlist</p>";
                $pagina=$partes[0] . $error . $partes[2];
            }else{
                $contenido = "";
                $lista = "";
                foreach ($canciones as $cancion) {
                    $lista = $partes[1];
                    $lista = str_replace("##CPOSICION##", 1, $lista);
                    $lista = str_replace("##CTITULO##", $cancion['Titulo'], $lista);
                    $lista = str_replace("##CAUTOR##", $cancion['Artista'], $lista);
                    $lista = str_replace("##CALBUM##", $cancion['Album'], $lista);
                    $lista = str_replace("##CGENERO##",$cancion['Genero'], $lista);
                    $lista = str_replace("##CAÑO##", $cancion['Año'], $lista);
                    $lista = str_replace("##CVALORACION##", $cancion['ValoracionSemanal'], $lista);
                    $lista = str_replace("##ID##", $cancion['Id'], $lista);
                    $contenido .= $lista;
                }
                $pagina=$partes[0] . $contenido . $partes[2];
            }
            //3ºComentarios de la cancion
            $partes = explode("##FILACOMENTARIO##", $pagina);
            if ($comentarios==null){
                $error="<p>No hay comentarios ¡Escribe el primero!</p>";
                $pagina=$partes[0] . $error . $partes[2];  
            }else{
                $contenido = "";
                $lista = "";
                foreach ($comentarios as $comentario) {
                    $lista = $partes[1];
                    $lista = str_replace("##COMAUTOR##", $comentario['Usuario'], $lista);
                    $lista = str_replace("##COMCOMENTARIO##", $comentario['Comentario'], $lista);
                    $lista = str_replace("##COMID##", $comentario['Id'], $lista);
                    $contenido .= $lista;
                }
                $pagina=$partes[0] . $contenido . $partes[2]; 
            }
            //4º Comentar si es un usuario
            $partes = explode("##COMENTAR##", $pagina);
			$contenido = $partes[1];
            if (isset($_SESSION['usuario'])){//esta logeado
                $contenido = str_replace("##UID##", $_SESSION['usuario'], $contenido);
                $contenido = str_replace("##PID##", $info['Id'], $contenido);
                $pagina=$partes[0] . $contenido . $partes[2]; 
            }else{
                $contenido = "<p>Logeate para poder comentar. Si no tienes cuenta, registrate!";
                $pagina=$partes[0] . $contenido . $partes[2]; 
            }
            echo $pagina;
        }
        function vcrearPlaylist(){
            $aux=leerfichero('fonts/crearPlaylist.html');
            echo $aux;  
        }
        function vmodPlaylist($info,$canciones){
            $pagina = leerfichero("fonts/modificarPlaylist.html");
             if ($info==null){//no exite playlist
                echo "<p><b>Error, no existe la playlist seleccionada</b>";
                return;
            }
            if (!isSet($_SESSION['usuario']) || $_SESSION['usuario']!=$info['Usuario']){//no es el autor, no puede ver  esto
                echo "<p><strong>Usted no es el autor de esta Playlist!</strong></p>";
                return;
            }
            //Info actual de la playlist
            $pagina=str_replace("##PTITULO##", $info['Nombre'], $pagina);
            $pagina=str_replace("##PID##", $info['Id'], $pagina);
            $pagina=str_replace("##PASUNTO##", $info['Asunto'], $pagina);
            $pagina=str_replace("##PDESCRIP##", $info['Descripcion'], $pagina);
            //canciones de la playlist
            $partes = explode("##FILACANCION##", $pagina);
            if ($canciones==null){
                $error="<p>No hay canciones en esta playlist</p>";
                $pagina=$partes[0] . $error . $partes[2];
            }else{
                $contenido = "";
                $lista = "";
                $i=1;
                foreach ($canciones as $cancion) {
                    $lista = $partes[1];
                    $lista = str_replace("##CPOSICION##", $i++, $lista);
                    $lista = str_replace("##CTITULO##", $cancion['Titulo'], $lista);
                    $lista = str_replace("##CAUTOR##", $cancion['Autor'], $lista);
                    $lista = str_replace("##CALBUM##", $cancion['Album'], $lista);
                    $lista = str_replace("##CGENERO##",$cancion['Genero'], $lista);
                    $lista = str_replace("##CAÑO##", $cancion['Año'], $lista);
                    $lista = str_replace("##CVALORACION##", $cancion['ValoracionSemanal'], $lista);
                    $lista = str_replace("##CID##", $cancion['Id'], $lista);
                    $contenido .= $lista;
                }
                $pagina=$partes[0] . $contenido . $partes[2];
            }
            echo $pagina;
        }
?>
