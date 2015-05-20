<?php
    include("modelo.php");
    include("vista.php");
    /*
     * Falta por hacer:
     * -PDF que se genere al vuelo
     * -AJAX de playlist
     * -Mensajes de confirmacion y de error
     * -Paginacion en tablas
     * -Poner bonitas las vistas
     * -Probar
     */
	$accion = "TL";
	$id = 1;

	session_start();
	
    if(isset($_GET["accion"]))
    {
        $accion = $_GET["accion"];
    }
    if(isset($_POST["accion"]))
    {
        $accion = $_POST["accion"];
    }
    if(isset($_GET["id"]))
    {
         $id = $_GET["id"];
    }
    if(isset($_POST["id"]))
    {
         $id = $_POST["id"];
    }
    
    if(isset($_POST["uid"],$_POST["pw"]))
    {
        $uid = $_POST["uid"];
        $pw = $_POST["pw"];
        $usuario = mLogin($uid, $pw);
		if ($usuario != false)
		{
			$_SESSION["usuario"] = $usuario;
		}
    }
	
        //cambiar contraseña
	if (($accion == "CC") and (isset($_SESSION["usuario"])))
	{
		vmostrarPreferencias();
		vmostrarCambiocontraseña();
		vmostrarContactar();
	}
	
        //cambiar correo
	if (($accion == "CE") and (isset($_SESSION["usuario"])))
	{
		vmostrarPreferencias();
		vmostrarCambiocorreo();
		vmostrarContactar();
	}
	
        //eliminar cuenta
	if (($accion == "EC") and (isset($_SESSION["usuario"])))
	{
		vmostrarPreferencias();
		vmostrarEliminarcuenta();
		vmostrarContactar();
	}
	
        //recuperar contraseña
	if ($accion == "REC")
	{
		switch($id)
		{
			case 1:		vmostrarRecuperar();
						vmostrarContactar();
						break;
			case 2:		mensajeOK();
						break;
		}
	}
	
        //alta usuario
	if($accion == "ALTA")
    {
		switch($id)
		{
			case 1:		vmostrarRegistro();
						vmostrarContactar();
						break;
			case 2:		mensajeOK();
						break;
		}
	}
	
        //log out (deslogearse)
	if ($accion == "OUT")
	{
		session_destroy();
		vmostrarLogin();
        vmostrarImenu();
		$datos = mToplistas();
        vmostrarToplistas($datos);
		vmostrarContactar();
	}
	
        //mostrar contacto?????
	if ($accion == "C")
	{
		vmostrarContacto();
	}
	
        //buscar
	if (($accion == "B") and (isset($_GET["buscar"])))
	{
		$datos = mBuscar($_GET["buscar"],$_GET["tipo"]);
		switch($_GET["tipo"])
		{
			case 0:		vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
						vmostrarRmenu();
						vmostrarBuscarlistas($_GET["buscar"],$datos);
						vmostrarContactar();
						break;
			
			case 1:		vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
						vmostrarRmenu();
						vmostrarBuscarcanciones($_GET["buscar"],$datos);
						vmostrarContactar();
						break;
		}
	}
	
        //mostrar Top Listas
    if($accion == "TL")
    {
        if (!isset($_SESSION["usuario"]))
        {
            vmostrarLogin();
            vmostrarImenu();
        }
        else
        {
            vmostrarUsuario($_SESSION["usuario"]);
            vmostrarBuscardor();
            vmostrarRmenu();
        }
        $datos = mToplistas($_SESSION["usuario"]);
        vmostrarToplistas($datos);
		vmostrarContactar();
    }

    //mostrar Top Canciones
    if($accion == "TC")
    {
        if (!isset($_SESSION["usuario"]))
        {
            vmostrarLogin();
            vmostrarImenu();
        }
        else
        {
            vmostrarUsuario($_SESSION["usuario"]);
            vmostrarBuscardor();
		    vmostrarRmenu();
        }
		$datos = mTopcanciones($_SESSION["usuario"]);
		vmostrarTopcanciones($datos);
		vmostrarContactar();
    }
	
    //mostrar Mis Listas
	if (($accion == "ML") and (isset($_SESSION["usuario"])))
	{
            vmostrarUsuario($_SESSION["usuario"]);
            vmostrarBuscardor();
            vmostrarRmenu();
            $datos = mMislistas($_SESSION["usuario"]);
            vmostrarMislistas($datos);
            vmostrarContactar();
	}
	
        //mostrar Mis Favoritos
	if (($accion == "MF") and (isset($_SESSION["usuario"])))
	{
		vmostrarUsuario($_SESSION["usuario"]);
		vmostrarBuscardor();
        vmostrarRmenu();
		$datos = mMisfavoritos($_SESSION["usuario"]);
		vmostrarMisfavoritos($datos);
		vmostrarContactar();
	}
	
        //Ver Playist (ver una sola lista)
	if($accion == "VP"){
		if (!isset($_SESSION["usuario"])){
			vmostrarLogin();
			vmostrarImenu();
		}else{
			vmostrarUsuario($_SESSION["usuario"]);
			vmostrarBuscardor();
			vmostrarRmenu();
		}
		$datos = minfoplaylist($_GET['pid']);
		$canciones=mcancionesplaylist($_GET['pid']);
		$comentarios=mcomplaylist($_GET['pid']);
		vmostrarLista($datos,$canciones,$comentarios);
		vmostrarContactar();
	}
        
       //Nueva Lista
        if ($accion=="NL" && isset($_SESSION['usuario'])){
            switch ($id){
                case 1:vmostrarUsuario($_SESSION["usuario"]);//mostrar formulario
			vmostrarBuscardor();
			vmostrarRmenu();
                        vcrearPlaylist();
                        break;
                case 2:$exito=mcrearPlaylist($_SESSION['usuario'],$_POST['Ptitulo'], $_POST['Pasunto'], $_POST['Pdescrip']);
                        vmostrarBuscardor();
			vmostrarRmenu();
                        if ($exito){
                            echo "Creada con exito";//cambiar
                        }
                        else{
                            vcrearPlaylist();
                        }
                        break;
            }
        }
        
        //Modificar Lista
        if ($accion=="MODL"){
            switch ($id){
                case 1: vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
			vmostrarBuscardor();
			vmostrarRmenu();
                        $infoplaylist=minfoplaylist($_GET['pid']);
                        $canciones=mcancionesplaylist($_GET['pid']);
                        vmodPlaylist($infoplaylist,$canciones);
                        break;
                case 2://modificar la info de playlist
                        vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
			vmostrarBuscardor();
			vmostrarRmenu();
                        $exito=mactualizarPlaylist($_POST['pid'],$_POST['Ptitulo'],$_POST['Pasunto'],$_POST['Pdescrip']);
                        if ($exito==true){
                            echo "exito al actualizar";//cambiar
                        }else{
                            echo "error al actualizar";//cambiar
                        }
                        break;
                case 3://añadir cancion  AJAX
                    var_dump($_GET['cid']);
                    var_dump($_GET['pid']);
                        $exito=mañadirCancionPlaylist($_GET['cid'], $_GET['pid']);
                        if ($exito){
                            echo "exito al añadir cancion";//cambiar
                        }else{
                            echo "fallo al añadir la cancion"; //cambiar
                        }
                        break;
                case 4://quitar canciones 
                        $exito=mquitarCancionPlaylist($_GET['cid'], $_GET['pid']);
                        if ($exito){
                            echo "exito al quitar cancion";//cambiar
                        }else{
                            echo "fallo al quitar la cancion"; //cambiar
                        }
                        break;
            }
        }
        
        //Ver Cancion (una sola cancion)
	if($accion == "VC")
    {
        switch ($id)
		{
			case 1:	if (!isset($_SESSION["usuario"])){
                                    vmostrarLogin();
                                    vmostrarImenu();
				}else{
                                        vmostrarUsuario($_SESSION["usuario"]);
                                        vmostrarBuscardor();
                                        vmostrarRmenu();
                                }
                                break;
			case 2:		if (!isset($_SESSION["admin"]))//esto pa que sirve????
						{
							echo "no eres admin"; 
						}
						else
						{
							vmostrarUsuario($_SESSION["admin"]);
							vmostrarBuscardor();
							vmostrarAmenu();
						}
		}
        $datos1 = mCancion($_GET["cid"]);
	$datos2 = mToplistascancion($_GET["cid"]);
        $playlist=mobtenerPlaylist($_SESSION['usuario']);
        vmostrarCancion($datos1,$datos2,$playlist);
	vmostrarContactar();
    }
    
    //Publicar Un comentario
    if ($accion=="PUC"){
        if (isset($_POST['uid']) && $_POST['uid']==$_SESSION['usuario']){//es quien dice ser
            $exito=mpublicarComentario($_POST['uid'],$_POST['pid'],$_POST['comentario']);
            vmostrarLogin();
            vmostrarImenu();//hacerlo en nueva pagina o con js sin recargar???
            $datos = minfoplaylist($_POST['pid']);
            $canciones=mcancionesplaylist($_POST['pid']);
            $comentarios=mcomplaylist($_POST['pid']);
            vmostrarLista($datos,$canciones,$comentarios);
            vmostrarContactar();
        }else{
            echo "no puede hacer eso!";
        }
    }
	
	//Puntuar Cancion
	if($accion == "PC")
	{
		$id = $_GET["id"];
		$p = $_GET["p"];
		$usuario = $_SESSION['usuario'];
		//$con = conexion();
		/* si no se ha valorau aun insert*/
		list($resultado1, $resultado2) = mPuntuacioncancion($id,$p,$usuario);
		//$resultado1 = mysql_query("UPDATE puntuacioncanciones SET Valoracion = '$p' WHERE Cancion = '$id' and Usuario = '$usuario';",$con);
		//$resultado2 = mysql_query("select (p.Valoracion * 8) as Valoracion from puntuacioncanciones p WHERE Cancion = '$id' and Usuario = '$usuario'",$con);
		$datos = mysql_fetch_assoc($resultado2);
		if (($resultado1 == false) or ($resultado2 == false))
		{
			echo "-1";
		}
		else
		{
			echo $datos["Valoracion"];
		}
	}
	
        //Puntuar Playlist
	if($accion == "PP")
	{
		$id = $_GET["id"];
		$p = $_GET["p"];
		$usuario = $_SESSION['usuario'];
		/* si no se ha valorau aun insert*/
		list($resultado1, $resultado2) = mPuntuacionplaylist($id,$p,$usuario);
		$datos = mysql_fetch_assoc($resultado2);
		if (($resultado1 == false) or ($resultado2 == false))
		{
			echo "-1";
		}
		else
		{
			echo $datos["Valoracion"];
		}
	}
	
	////////////////////////////////////////////////////////////////////////
	if ($accion=="admin"){//login admin
		switch ($id){
			case 2:$nombre=adminlogin($_POST['aid'], $_POST['apw']);
				if ($nombre!==false)
				{
					$_SESSION['admin']=$nombre;
					vmostrarAmenu();
					$datos = mReportes();
					vmostrarReportes($datos);
					vmostrarUsuario($_SESSION["admin"]);
				}
				else
				{//error ususario incorrecto
					vloginadmin();
				}
				break;
			default:vloginadmin();
		}
	}
	
        if ($accion== "AR"){ //administrar reportes
            if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){
                vmostrarAmenu();
                switch ($id){
                    case 1: //mostrar reportes
                            if (isset($_GET['verignorados'])&& $_GET['verignorados']==1){//mostramos los reportes ignorados por el admin anteriormente
                                $ignorados=mobtenerReportesIgnorados();
                                vmostrarReportesIgnorados($ignorados);    
                            }else{//mostramos los reportes de los comentarios
                                $reportes=mobtenerReportes();
                                vmostrarReportes($reportes);
                            }
                            break;
                    case 2:$rest=mborrarComentario($_GET['idcomentario']);//eliminar comentario
                            if ($rest==false){
                                mostrarError("No se ha podido eliminar", "Error al eliminar el comentario");
                            }
                            $reportes=mobtenerReportes();
                            vmostrarReportes($reportes);
                            break;
                    case 3:mignorar($_GET['ignorar']);//ignorar comentario
                           vmostrarReportes($reportes);
                           break;
                    default:vmostrarAmenu();
               }
            }else{
               mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion");
            }
	}
	
	if ($accion == "AC"){//alta cancion
		if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){ //es un admin
			switch ($id)
			{
				case 1: 	vmostrarAmenu();
							$datos = mCanciones();
							vmostrarCanciones($datos);
							vmostrarUsuario($_SESSION["admin"]);
							 //mostrar el formulario
							break;
				case 2: 	valtaCancion();
							break;
				
				case 3: 	if (añadirCancion($_POST['titulo'], $_POST['autor'], $_POST['album'], $_POST['genero'], $_POST['año'], $_FILES["caratula"],$_FILES["cancion"]))
							{
							//exito, añadido. mostrar mensaje y pa dejar pa añadir otra
							echo "cancion añadida con exito";
							vmostrarAmenu();
							}
							else
							{
								//fallo, enviar mensajede fallo y k vuelva a intentarlo
								echo "fallo";
								valtacancion();
							}
							break;
				case 4: 	mborrarCancion($_GET["idc"]);
							break;
			}
		}else{
			echo "necesitas ser administrador";
		}
	}
	if ($accion == "BC"){//borrar cancion
		if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){ //es un admin
			switch ($id){
				case 1: vbuscarborrar(); //mostrar el buscador
						break;
				case 2://mostrar resultados
					switch ($_GET['buscar']){
						case 1:$canciones=mbuscartitulo($_GET['busqueda']);//titulo
							vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
							vcancionesborrar($canciones);
							break;
                                                case 2:$autores=  mbuscarautor($_GET['busqueda']);//autor
                                                        vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                                        vautorborrar($autores);
                                                        break;
                                                case 3:$albumnes=mbuscaralbum($_GET['busqueda']);//album(disco)
                                                        vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                                        valbumborrar($albumnes);
                                                        break;
					}
					break;
                                case 3: if (mborrarCancion($_GET['idcancion'])){
                                            echo "eliminado con exito";
                                            vmostrarAmenu();
                                        }else{
                                            echo 'fallo al eliminar';
                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                        }
					break;
                                case 4:$cancionesaborrar=cancionesautor($_GET['autor']);//confirmar borrar autor
                                        $_SESSION['cancionesborrar']=$cancionesaborrar;
                                        vmostrarconfirmacion($cancionesaborrar);
                                        break;
                                case 5:$cancionesaborrar=cancionesalbum($_GET['album']);//confirmar borrar disco
                                        $_SESSION['cancionesborrar']=$cancionesaborrar;
                                        vmostrarconfirmacion($cancionesaborrar);
                                        break;
                                case 6:$res=mborrarCanciones($_SESSION['cancionesborrar']);
                                        vmostrarExito($res);
                                        break;
                                    
                                }//fin switch $id
		}else{
			echo "necesitas ser administrador";
		}
	}
	/////////////////////////////////////////////////////////////////////////
?>
