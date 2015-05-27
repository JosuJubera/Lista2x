<?php
    include("modelo.php");
    include("vista.php");
    //error_reporting(0); //borrar esto
    /*
     * Falta por hacer:
     * -AJAX de playlist (Reproductor) ya mañana
     * -Refres en MF (recargar la pagina tras votar)
     * -Mensajes de confirmacion y de error
     * -Comprobar los back
     * -Comprobaciones SQL(limpiar entrada)
     * -Paginacion en tablas
     * -CSS
     * -Alta usuario (con JS y redirect)
     * -Añadir opcion para ir a la pagina principal
     * -Añadir mensajes de Info y de Error con JS. Si es necesario usar redirect
     * -Probar la pagina
	 -funcion mostrar mensaje
	 -contacto
	 -admin (vistas, funcionalidad...)
     */
    session_start();
    //Vistas por defecto
    $accion = "TL";
    $id = 1;
    if (isset($_SESSION['admin'])){
        $accion = "AR";
        $id = 1; 
    }
	
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
	if (($accion == "CC") and ((isset($_SESSION["usuario"])) or (isset($_SESSION["admin"]))))
	{
		switch ($id)
		{
			case 1:		vmostrarPreferencias();
						vmensaje();
						vmostrarCambiocontraseña();
						vmostrarContactar();
						break;
			case 2:		vmostrarPreferencias();
						vmostrarCambiocontraseña();
						vmostrarContactar();
						$dato1 = $_POST["uid"];
						$dato2 = $_POST["pwa"];
						$dato3 = $_POST["pw"];
						$resultado = mCambiarcontraseña($dato1,$dato2,$dato3);
						var_dump($resultado);
		}
	}
	
    //cambiar correo
	if (($accion == "CE") and (isset($_SESSION["usuario"]))or (isset($_SESSION["admin"])))
	{
		vmostrarPreferencias();
		vmostrarCambiocorreo();
		vmostrarContactar();
	}
	
	//eliminar cuenta
	if (($accion == "EC") and (isset($_SESSION["usuario"]))or (isset($_SESSION["admin"])))
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
			case 1:		vmostrarImenu();
						vmostrarRegistro();
						vmostrarContactar();
						break;
			case 2:		mAlta($_POST["uid"],$_POST["uname"],$_POST["lastname"],$_POST["lastname2"],$_POST["email"],$_POST["pass"]);
						vmostrarRmenu();
						break;
		}
	}
	
	//log out (deslogearse)
	if ($accion == "OUT")
	{
		session_destroy();
        vmostrarImenu();
		vmostrarLogin();
		$datos = mIToplistas();
        vmostrarIToplistas($datos);
		vmostrarContactar();
	}
	
	//mostrar contacto?????
	/*
	if ($accion == "C")
	{
		switch($id)
		{
			case 1: 	vmostrarContacto();
						break;
			case 2: 	@$nombre = addslashes($_POST['uid']);
						@$email = addslashes($_POST['cu']);
						@$mensaje = addslashes($_POST['message']);
						 
						//Preparamos el mensaje de contacto
						$cabeceras = "From: $email\n" //La persona que envia el correo
						 . "Reply-To: $email\n";
						$asunto = "Contacto Lista2x"; //asunto aparecera en la bandeja del servidor de correo
						$email_to = "josujubera@hotmail.com"; //cambiar por tu email
						$contenido = "$nombre ha enviado un mensaje desde la web de Lista2x\n"
						. "\n"
						. "Nombre: $nombre\n"
						. "Email: $email\n"
						. "Mensaje: $mensaje\n"
						. "\n";
						 
						//Enviamos el mensaje y comprobamos el resultado
						if (@mail($email_to, $asunto ,$contenido ,$cabeceras ))
						{
							//Si el mensaje se envía muestra una confirmación
							die("Gracias, su mensaje se envio correctamente.");
						}
						else
						{
							//Si el mensaje no se envía muestra el mensaje de error
							die("Error: Su información no pudo ser enviada, intente más tarde");
						}
						break;
		}	
	}*/
	
	//buscar
	if (($accion == "B") and (isset($_GET["search"])))
	{
		$datos = mBuscar($_GET["search"],$_GET["tipo"],$_SESSION["usuario"]);
		if ($datos == null)
		{
			vmensaje("No se ha podido encontrar.", "alerta");
		}
		switch($_GET["tipo"])
		{
			case 0:		vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
						vmensaje();
						vmostrarBuscarlistas($_GET["search"],$datos);
						vmostrarContactar();
						break;
			
			case 1:		vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
						vmensaje();
						vmostrarBuscarcanciones($_GET["search"],$datos);
						vmostrarContactar();
						break;
		}
	}
	
	//mostrar Top Listas
    if($accion == "TL")
    {
        if (!isset($_SESSION["usuario"]))
        {
            vmostrarImenu();
            vmostrarLogin();
			vmensaje();
			$datos = mIToplistas();
			vmostrarIToplistas($datos);
			vmostrarContactar();
        }
        else
        {
            vmostrarRmenu();
            vmostrarUsuario($_SESSION["usuario"]);
            vmostrarBuscardor();
			vmensaje();
			$datos = mToplistas($_SESSION["usuario"]);
			vmostrarToplistas($datos);
			vmostrarContactar();
        }		
    }

    //mostrar Top Canciones
    if($accion == "TC")
    {
        if (!isset($_SESSION["usuario"]))
        {
            vmostrarImenu();
            vmostrarLogin();
			vmensaje();
			$datos = mITopcanciones();
			vmostrarITopcanciones($datos);
			vmostrarContactar();
        }
        else
        {
		    vmostrarRmenu();
            vmostrarUsuario($_SESSION["usuario"]);
            vmostrarBuscardor();
			vmensaje();
			$datos = mTopcanciones($_SESSION["usuario"]);
			vmostrarTopcanciones($datos);
			vmostrarContactar();
        }
    }
	
    //mostrar Mis Listas
	if (($accion == "ML") and (isset($_SESSION["usuario"])))
	{
            vmostrarRmenu();
            vmostrarUsuario($_SESSION["usuario"]);
            vmostrarBuscardor();
            $datos = mMislistas($_SESSION["usuario"]);
            vmostrarMislistas($datos);
            vmostrarContactar();
	}
	
	//mostrar Mis Favoritos
	if (($accion == "MF") and (isset($_SESSION["usuario"])))
	{
        vmostrarRmenu();
		vmostrarUsuario($_SESSION["usuario"]);
		vmostrarBuscardor();
		$datos = mMisfavoritos($_SESSION["usuario"]);
		vmostrarMisfavoritos($datos);
		vmostrarContactar();
	}
	
	//Ver Playist (ver una sola lista)
	if($accion == "VP"){
            switch ($id){
                case 2://Ver los comentarios de la pagina X (AJAX)
                    $pagina=$_GET['pag'];
                    $pid=$_GET['pid'];
                    $comentarios=mcomplaylist($pid,$pagina);
                    $ncomentarios=mnumcomplaylist($pid);
                    venviarComentarios($comentarios,$ncomentarios);
                    break;
                default: //simplemente mustra la playlist
                    if (!isset($_SESSION["usuario"])){
                            vmostrarImenu();
                            vmostrarLogin();
                    }else{
                            vmostrarRmenu();
                            vmostrarUsuario($_SESSION["usuario"]);
                            vmostrarBuscardor();
                    }
                    $datos = minfoplaylist($_GET['pid']);
                    $canciones=mcancionesplaylist($_GET['pid']);
                    $comentarios=mcomplaylist($_GET['pid']);
                    $ncomentarios=mnumcomplaylist($_GET['pid']);
                    vmostrarLista($datos,$canciones,$comentarios,$ncomentarios);
                    vmostrarContactar();
            }
	}
        
	//Nueva Lista
	if ($accion=="NL" && isset($_SESSION['usuario'])){
		switch ($id){
			case 1:		vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);//mostrar formulario
						vmostrarBuscardor();
						vcrearPlaylist();
						break;
			case 2:		vmostrarRmenu();
						$exito=mcrearPlaylist($_SESSION['usuario'],$_POST['Ptitulo'], $_POST['Pasunto'], $_POST['Pdescrip']);
						vmostrarBuscardor();
		
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
			case 1: 		vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
						vmostrarBuscardor();
						$infoplaylist=minfoplaylist($_GET['pid']);
						$canciones=mcancionesplaylist($_GET['pid']);
						vmodPlaylist($infoplaylist,$canciones);
						break;
			case 2://modificar la info de playlist
					vmostrarRmenu();
					vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
					vmostrarBuscardor();
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
						vmostrarImenu();
						vmostrarLogin();
					}else{
						vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
					}
					break;
			case 2:		if (!isset($_SESSION["admin"]))//esto pa que sirve????
						{
							echo "no eres admin"; 
						}
						else
						{
							vmostrarAmenu();
							vmostrarUsuario($_SESSION["admin"]);
							vmostrarBuscardor();
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
            vmostrarImenu();//hacerlo en nueva pagina o con js sin recargar???
            vmostrarLogin();
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
		list($resultado1, $resultado2) = mPuntuacioncancion($id,$p,$usuario);
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
	//Generar PDF
	if ($accion=="PDF"){
            $canciones=  mcancionesplaylist($_GET['pid']);
            vgenerarPDF($canciones);
        }
	////////////////////////////////////////////////////////////////////////
	if ($accion=="admin"){//login admin
		switch ($id){
			case 2:$nombre=adminlogin($_POST['aid'], $_POST['apw']);
				if ($nombre!==false)
				{
					vmostrarAmenu();
					$_SESSION['admin']=$nombre;
					$datos = mReportes();
					vmostrarReportes($datos);
					vmostrarAUsuario($_SESSION["admin"]);
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
	
	if ($accion == "AU")
	{
            if (isset($_SESSION["admin"]))
            {
                switch ($id)
                {
                    case 1: vmostrarAmenu();
                            $datos = mUsuarios();
                            vmostrarUsuarios($datos);
                            vmostrarAUsuario($_SESSION["admin"]);
                            break;
                    case 2: if (mborrarUsuario($_GET['user'])){
                                mostrarInfo("Usuario eliminado con exito!");
                            }else{
                                mostrarError("Imposible eliminar",
                                "No se ha podido eliminar el usuario. Puede que ya haya sido eliminado o no exista");
                            }
                            break;
                }
            }
        }
	
    if ($accion == "AC"){//alta cancion
        if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){ //es un admin
                switch ($id)
                {
                    case 1:     vmostrarAmenu();
                                $datos = mCanciones();
                                vmostrarCanciones($datos);
                                vmostrarAUsuario($_SESSION["admin"]);
                                break;
                    case 2: 	vmostrarAmenu();
                                vmostrarAUsuario($_SESSION["admin"]);
                                valtaCancion();
                                break;
                            
                    case 3: 	if (añadirCancion($_POST['titulo'], $_POST['autor'], $_POST['album'], $_POST['genero'], $_POST['año'], $_FILES["caratula"],$_FILES["cancion"]))
                                    {
                                    //exito, añadido. mostrar mensaje y pa dejar pa añadir otra
                                    vmostrarAmenu();
                                    echo "cancion añadida con exito";
                                    }
                                    else
                                    {
                                        //fallo, enviar mensajede fallo y k vuelva a intentarlo
                                        echo "fallo";
                                        valtacancion();
                                    }
                                    break;
                    case 4:     mborrarCancion($_GET["idc"]);
                                break;
                    }
            }else{
                    echo "necesitas ser administrador";
            }
	}
	if ($accion == "BC"){//borrar cancion
		if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/)
		{ //es un admin
			switch ($id)
			{
				case 1:     vmostrarAmenu();
                                            vmostrarAUsuario($_SESSION["admin"]);
                                            vbuscarborrar(); //mostrar el buscador
                                            break;
				case 2:		//mostrar resultados
                                            switch ($_GET['buscar'])
                                            {
                                                case 1:     vmostrarAmenu();
                                                            vmostrarAUsuario($_SESSION["admin"]);     
                                                            $canciones=mbuscartitulo($_GET['busqueda']);//titulo
                                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                                            vcancionesborrar($canciones);
                                                            break;
                                                case 2:     vmostrarAmenu();
                                                            vmostrarAUsuario($_SESSION["admin"]);     
                                                            $autores= mbuscarautor($_GET['busqueda']);//autor
                                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                                            vautorborrar($autores);
                                                            break;
                                                case 3:     vmostrarAmenu();
                                                            vmostrarAUsuario($_SESSION["admin"]);
                                                            $albumnes=mbuscaralbum($_GET['busqueda']);//album(disco)
                                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                                            valbumborrar($albumnes);
                                                            break;
                                            }
                                            break;
                                case 3:     if (mborrarCancion($_GET['idcancion'])){
                                                mostrarInfo("Cancion borrada correctamente");
                                            }else{
                                                mostrarError("Error al eliminar", "No se ha podido eliminar la cancion");
                                                vmostrarAmenu();
                                                vmostrarAUsuario($_SESSION["admin"]);
                                                vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                            }
                                            break;
				case 4:     $cancionesaborrar=  cancionesautor($_GET['autor']);
                                            $_SESSION['cancionesborrar']=$cancionesaborrar;//guardamos en la sesion (tambien se podria x cookies)
                                            vmostrarAmenu();
                                            vmostrarconfirmacion($cancionesaborrar);
                                            vmostrarAUsuario($_SESSION["admin"]);
                                            break;
                                case 5:     $cancionesaborrar=cancionesalbum($_GET['album']);//confirmar borrar disco
                                            $_SESSION['cancionesborrar']=$cancionesaborrar;//guardamos en sesion (tambien se podria x cookies)
                                            vmostrarAmenu();
                                            vmostrarconfirmacion($cancionesaborrar);
                                            vmostrarAUsuario($_SESSION["admin"]);
                                            break;
				case 6:     $res=mborrarCanciones($_SESSION['cancionesborrar']);//borramos
                                            header("Location: index.php");//volvemos al index
                                            break;                   
			}//fin switch $id
		}else{
			echo "necesitas ser administrador";
		}
	}
	/////////////////////////////////////////////////////////////////////////
?>
