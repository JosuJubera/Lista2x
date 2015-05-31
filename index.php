<?php
    include("modelo.php");
    include("vista.php");
    //error_reporting(0); //borrar esto
    /*
     * Falta por hacer:
     * -Refres en MF (recargar la pagina tras votar)
     * -Comprobar los back                             ////quedan algunos que iwal mejor cambiar a imagen pa tener todos iwal
     * -Comprobaciones SQL(limpiar entrada)
     * -Paginacion en tablas
     * -CSS
     * -arreglar preferencias admin                      ////hecho
	 * -preferencias  CC, EC, CE ////////////habria que comprobar que realmente se hacen los cambios, iwal probar con un select despues
     * -Mensajes de confirmacion y de error
	 -funcion mostrar mensaje
     * -Añadir mensajes de Info y de Error con JS en Regisgtro.
     * -en registro usuario comprobar que se registra bien //////////////creo que hecho bien
     * -Añadir mensaje error o no en alta cancion.
     * -Al borrar comentario ir a los reportes
	 * -Reportes   ///////////////////////////redirigir falla
	 -admin (vistas, funcionalidad...)
	 - poner añadir lista como añadir cancion y borrar pero que salga en horizontal es decir desplegable
	 * -Probar la pagina
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
    
    if(isset($_POST["uid"],$_POST["pw"],$_POST["tipo"]))
    {
        $uid = $_POST["uid"];
        $pw = $_POST["pw"];
		$tipo = $_POST["tipo"];
        $usuario = mLogin($uid, $pw);
		if ($usuario != false)
		{
			$_SESSION["usuario"] = $usuario;
			$_SESSION["tipo"] = $tipo;
		}
    }
	
    //cambiar contraseña
	if (($accion == "CC") && ((isset($_SESSION["usuario"])) || (isset($_SESSION["admin"]))))///////////////Limitar quien puede cambiar la pass
	{
		switch ($id)
		{
			case 1:		vmostrarPreferencias($_SESSION["tipo"]);
						vmensaje();
						vmostrarCambiocontraseña();
						if (!(isset($_SESSION["admin"])))
						{
							vmostrarContactar();
						}
						break;
			case 2:		vmostrarPreferencias($_SESSION["tipo"]);
						vmostrarCambiocontraseña();
						if (!(isset($_SESSION["admin"])))
						{
							vmostrarContactar();
						}
						if (($_POST["uid"] == $_SESSION["admin"]) || ($_POST["uid"] == $_SESSION["usuario"]))
						{
							$uid = $_POST["uid"];
							$pwa = $_POST["pwa"];
							$pw = $_POST["pw"];
							if (!(isset($_SESSION["admin"])))
							{
								$resultado = mCambiarcontraseña($uid,$pwa,$pw);
							}
							else
							{
								$resultado = mACambiarcontraseña($uid,$pwa,$pw);
							}
							if ($resultado)
							{
								echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Se ha cambiado la contraseña correctamente.</div>';
								header('Refresh: 3; url=index.php?accion=CC&id=1');
							}
							else
							{
								echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido cambiar la contraseña.</div>';
								header('Refresh: 3; url=index.php?accion=CC&id=1');
							}
						}
						else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">Introduce tu nombre de usuario.</div>';
							header('Refresh: 3; url=index.php?accion=CC&id=1');
						}
		}
	}
	
    //cambiar correo
	if (($accion == "CE") && ((isset($_SESSION["usuario"])) || (isset($_SESSION["admin"]))))////////////////////////////TERMINAR
	{
		switch ($id)
		{
			case 1:		vmostrarPreferencias($_SESSION["tipo"]);
						vmostrarCambiocorreo();
						if (!(isset($_SESSION["admin"])))
						{
							vmostrarContactar();
						}
						break;
			case 2: 	vmostrarPreferencias($_SESSION["tipo"]);
						vmostrarCambiocontraseña();
						if (!(isset($_SESSION["admin"])))
						{
							vmostrarContactar();
						}
						if (($_POST["uid"] == $_SESSION["admin"]) || ($_POST["uid"] == $_SESSION["usuario"]))
						{
							$uid = $_POST["uid"];
							if ($_POST['email'] == '' or preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/",$_POST['email']))
							{
								echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">El correo no es válido.</div>';
								header('Refresh: 3; url=index.php?accion=CE&id=1');
							}
							else
							{
								$emaila = $_POST["cau"];
							}
							$email = $_POST["cu"];
							if (!(isset($_SESSION["admin"])))
							{
								$resultado = mCambiaremail($uid,$emaila,$email);
							}
							else
							{
								$resultado = mACambiaremail($uid,$emaila,$email);
							}
							if ($resultado)
							{
								echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Se ha cambiado el correo correctamente.</div>';
								header('Refresh: 3; url=index.php?accion=CE&id=1');
							}
							else
							{
								echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido cambiar el correo.</div>';
								header('Refresh: 3; url=index.php?accion=CE&id=1');
							}
						}
						else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">Introduce tu nombre de usuario.</div>';
							header('Refresh: 3; url=index.php?accion=CE&id=1');
						}
		}
	}
	
	//eliminar cuenta
	if (($accion == "EC") && ((isset($_SESSION["usuario"])) || (isset($_SESSION["admin"]))))////////////////////////////TERMINAR
	{
		switch ($id)
		{
			case 1:		vmostrarPreferencias($_SESSION["tipo"]);
						vmostrarEliminarcuenta();
						if (!(isset($_SESSION["admin"])))
						{
							vmostrarContactar();
						}
						break;
			case 2:		vmostrarPreferencias($_SESSION["tipo"]);
						vmostrarCambiocontraseña();
						if (!(isset($_SESSION["admin"])))
						{
							vmostrarContactar();
						}
						if (($_POST["uid"] == $_SESSION["admin"]) || ($_POST["uid"] == $_SESSION["usuario"]))
						{
							$uid = $_POST["uid"];
							$email = $_POST["cu"];
							$pass = $_POST["pw"];
							if (!(isset($_SESSION["admin"])))
							{
								$resultado = mEliminarcuenta($uid,$email,$pass);
							}
							else
							{
								$resultado = mAEliminarcuenta($uid,$email,$pass);
							}
							if ($resultado)
							{
								echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Se ha eliminado la cuenta correctamente.</div>';
								header('Refresh: 3; url=index.php?accion=OUT&id=1');
							}
							else
							{
								echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido eliminar la cuenta.</div>';
								header('Refresh: 3; url=index.php?accion=EC&id=1');
							}
						}
						else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">Introduce tu nombre de usuario.</div>';
							header('Refresh: 3; url=index.php?accion=EC&id=1');
						}
		}
	}
	
	//recuperar contraseña
	if ($accion == "REC")////////////////////////////////////////////////////////////TERMINAR
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
						vmensaje();
						vmostrarRegistro();
						vmostrarContactar();
						break;
			case 2:		vmostrarImenu();
						vmensaje();
						vmostrarRegistro();
						vmostrarContactar();
						$resultado = mAlta($_POST["uid"],$_POST["uname"],$_POST["lastname"],$_POST["lastname2"],$_POST["email"],$_POST["pass"]);
						if ($resultado)
						{
							$usuario = mLogin($_POST["uid"], $_POST["pass"]);
							if ($usuario != false)
							{
								$_SESSION["usuario"] = $_POST["uid"];
								$_SESSION["tipo"] = "user";
								echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Te has registrado correctamente.</div>';
								header('Refresh: 3; url=index.php'); 
							}
							else
							{
								echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido logear.</div>';
								header('Refresh: 3; url=index.php?accion=ALTA&id=1');
							}
						}
						else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido registrar.</div>';
							header('Refresh: 3; url=index.php?accion=ALTA&id=1');
						}
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
                        vmostrarContactar();
						break;
			case 2:		vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);
                        vmostrarUsuario($_SESSION["usuario"]);//mostrar formulario
						vmostrarBuscardor();
						vcrearPlaylist();
						$exito=mcrearPlaylist($_SESSION['usuario'],$_POST['Ptitulo'], $_POST['Pasunto'], $_POST['Pdescrip']);
						vmostrarBuscardor();
						if ($exito)
						{
							echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Lista creada correctamente.</div>';
							header('Refresh: 3; url=index.php?accion=NL&id=1');
						}
						else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido crear la lista.</div>';
							header('Refresh: 3; url=index.php?accion=NL&id=1');
						}
						break;
						/*
						if ($exito){
                            mostrarInfo("Playlist creada con exito");
                        }
                        else{
                            mostrarError("Imposible crear", "No ha sido posible crear la playlist");
                        }
                        vmostrarContactar();
                        break;
						*/
		}
	}
        
	//Modificar Lista
	if ($accion=="MODL"){
		switch ($id){
            case 1:     vmostrarRmenu();
                        vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
                        vmostrarBuscardor();
                        $infoplaylist=minfoplaylist($_GET['pid']);
                        $canciones=mcancionesplaylist($_GET['pid']);
                        vmodPlaylist($infoplaylist,$canciones);
                        vmostrarContactar();
                        break;
			case 2:		//modificar la info de playlist
						vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
						vmostrarBuscardor();
						$exito=mactualizarPlaylist($_POST['pid'],$_POST['Ptitulo'],$_POST['Pasunto'],$_POST['Pdescrip']);
						if ($exito==true)
						{
							echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Lista modificada con exito.</div>';
							header('Refresh: 3; url=index.php?accion=MODL&id=1');
						}else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido modificar la lista.</div>';
							header('Refresh: 3; url=index.php?accion=MODL&id=1');
						}
						vmostrarContactar();
						break;
			case 3:		//añadir cancion  AJAX
						$exito=mañadirCancionPlaylist($_GET['cid'], $_GET['pid']);
                 /*       if ($exito){
                            echo '1';
                        }else{
                            echo '-1';
                        }
                  */
                
						if ($exito)
						{
							echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Canción añadida con exito.</div>';
							header('Refresh: 3; url=index.php?accion=MODL&id=1');
						}else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido añadir la canción.</div>';
							header('Refresh: 3; url=index.php?accion=MODL&id=1');
						}
                 
						break;
			case 4:		//quitar canciones 
						$exito=mquitarCancionPlaylist($_GET['cid'], $_GET['pid']);
						vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);//muestra la playlist
						vmostrarBuscardor();
						if ($exito)
						{
							echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Canción eliminada de la lista.</div>';
							header('Refresh: 3; url=index.php?accion=MODL&id=1');
						}else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido eliminar la canción de la lista.</div>';
							header('Refresh: 3; url=index.php?accion=MODL&id=1');
						}
						/*
						if ($exito){
							mostrarInfo("Cancion eliminada");
						}else{
							mostrarError("Error", "Imposible eliminar la cancion");
						}
						*/
						vmostrarContactar();
						break;
            case 5:		//eliminar playlist
						$exito=meliminarPlaylist($_GET['pid'],$_SESSION['usuario']);
						vmostrarRmenu();
						if ($exito){
							mostrarInfo("Lista eliminada");
						}else{
							mostrarError("Error", "No se ha podido eliminar la lista");
						}
						vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
						$datos = mTopcanciones($_SESSION["usuario"]);
						vmostrarTopcanciones($datos);
						vmostrarContactar();
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
        $playlist=mobtenerPlaylist(isset($_SESSION['usuario'])? $_SESSION['usuario']:null);
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
			echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No puede hacer eso.</div>'; ////////////////////aki ke hay que poner?
			header('Refresh: 3; url=index.php?accion=PUC&id=1');
            /*mostrarError("Autorizacion Necesaria", "Necesita estar logueado para hacer eso");*/
        }
    }
	
	// Reportar
	if ($accion == "RC")
	{
		switch ($id)
		{
			case 1:		vmostrarRmenu();
						vmostrarUsuario($_SESSION["usuario"]);
						vmostrarBuscardor();
						$datos = minfoplaylist($_GET['pid']);
						$canciones = mcancionesplaylist($_GET['pid']);
						$comentarios = mcomplaylist($_GET['pid']);
						$ncomentarios = mnumcomplaylist($_GET['pid']);
						vmostrarLista($datos,$canciones,$comentarios,$ncomentarios);
						vmostrarContactar();
						if (isset($_GET["cid"]))
						{
							$cid = $_GET["cid"];
							$pid = $_GET["pid"];
							$resultado = mReportar($cid);
							if ($resultado)
							{
								echo '<div class="exito mensajes" id="exito mensajes" style="visibility:visible;">Comentario reportado.</div>';
								header("Refresh: 3; url=index.php?accion=VP&id=1&pid=1");////////////parece que vmostrarLista no deja
							}
							else
							{
								echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido reportar.</div>';
								header('Refresh: 3; url=index.php?accion=VP&id=1&pid='. $pid);
							}
						}
						else
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No se ha podido reportar.</div>';
							header('Refresh: 3; url=index.php?accion=VP&id=1&pid='. $pid);
						}
						break;
		}
	}
	
	//Puntuar Cancion AJAX
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
	
	//Puntuar Playlist AJAX
	if($accion == "PP")
	{
		$id = $_GET["id"];
		$p = $_GET["p"];
		$usuario = $_SESSION['usuario'];
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
					$_SESSION['admin']=$nombre;
					$_SESSION["tipo"] = "admin";
                    header("Location: index.php");
				}
				else
				{//error ususario incorrecto
					vloginadmin("Usuario o contraseña incorrecta");
				}
				break;
			default:vloginadmin();
		}
	}
	//Actualizar puntuaciones
        if ($accion=="ACTU"){
            if (isset($_SESSION["admin"])){
                switch ($id){
                    case 1://Ver Opciones
                            vmostrarAmenu();
                            vactualizar();
                            vmostrarAUsuario($_SESSION["admin"]);
                            break;
                    case 2://Actualizar
                            vmostrarAmenu();
                            $exito=mactualizar();
                            if ($exito){
                                mostrarInfo("Actualizado con exito");
                            }else{
                                mostrarError("Error al actualizar", "No se puede actualizar las canciones");
                            }
                            vactualizar();
                            vmostrarAUsuario($_SESSION["admin"]);
                            break;
                }
                
            }else{
                 mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion"); 
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
                   vmostrarAUsuario($_SESSION["admin"]);
		}else{
		   mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion");
		}
	}
	
	if ($accion == "AU")
	{
		switch ($id)
		{
            case 1:		if (isset($_SESSION["admin"]))
						{
							vmostrarAmenu();
							$datos = mUsuarios();
							vmostrarUsuarios($datos);
							vmostrarAUsuario($_SESSION["admin"]);
						}
						else 
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No eres administrador.</div>';
							header('Refresh: 3; url=index.php?accion=admin&id=1');
						}
						break;
			case 2: 	if (isset($_SESSION["admin"]))
						{
                            $resultado = mborrarAUsuario($_GET['user']);
							vmostrarAmenu();
							$datos = mUsuarios();
							vmostrarUsuarios($datos);
							if ($resultado)
							{
								 mostrarInfo("Usuario eliminado con exito!");
                            }else{
								 mostrarError("Imposible eliminar",
-                                "No se ha podido eliminar el usuario. Puede que ya haya sido eliminado o no exista");
							}
                            vmostrarAUsuario($_SESSION["admin"]);
						}
						else//no es admin
						{
							echo '<div class="error mensajes" id="error mensajes" style="visibility:visible;">No eres administrador.</div>';
							header('Refresh: 3; url=index.php?accion=admin&id=1');
						}
						break;
        }
	}
	
    if ($accion == "AC"){//alta cancion
        if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){ //es un admin
                switch ($id)
                {
                    case 1:     vmostrarAmenu(); //esto pa que esta???
                                $datos = mCanciones();
                                vmostrarCanciones($datos);
                                vmostrarAUsuario($_SESSION["admin"]);
                                break;
                    case 2: 	vmostrarAmenu();
                                valtaCancion();
                                vmostrarAUsuario($_SESSION["admin"]);
                                break;
                            
                    case 3: 	if (añadirCancion($_POST['titulo'], $_POST['autor'], $_POST['album'], $_POST['genero'], $_POST['año'], $_FILES["caratula"],$_FILES["cancion"]))
                                    {
                                    //exito, añadido. mostrar mensaje y pa dejar pa añadir otra
                                    vmostrarAmenu();
                                    valtaCancion();
                                    mostrarInfo("Cancion añadida con exito");
                                    vmostrarAUsuario($_SESSION["admin"]);
                                    }
                                    else
                                    {
                                        vmostrarAmenu();
                                        valtaCancion();
                                        mostrarError("Imposible añadir", "No ha sido posible añadir la cancion.");
                                        vmostrarAUsuario($_SESSION["admin"]);
                                    }
                                    break;
                    case 4:    
                                vmostrarAmenu();
                                $exito=mborrarCancion($_GET["idc"]);
                                $datos = mCanciones();
                                vmostrarCanciones($datos);
                                if ($exito){
                                    mostrarInfo("Cancion eliminada");
                                }else{
                                    mostrarError("Imposible eliminar", "No ha sido posible eliminar la cancion");
                                }
                                vmostrarAUsuario($_SESSION["admin"]);
                                break;
                    }
            }else{
                mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion");
            }
	}
	if ($accion == "BC"){//borrar cancion
		if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/)
		{ //es un admin
			switch ($id)
			{
				case 1:     vmostrarAmenu();
                            vbuscarborrar(); //mostrar el buscador
                            vmostrarAUsuario($_SESSION["admin"]);
                            break;
				case 2:		//mostrar resultados
                            switch ($_GET['buscar'])
                            {
                                case 1:     vmostrarAmenu();
                                            $canciones=mbuscartitulo($_GET['busqueda']);//titulo
                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                            vcancionesborrar($canciones);
                                            vmostrarAUsuario($_SESSION["admin"]);     
                                            break;
                                case 2:     vmostrarAmenu();
                                            $autores= mbuscarautor($_GET['busqueda']);//autor
                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                            vautorborrar($autores);
                                            vmostrarAUsuario($_SESSION["admin"]);    
                                            break;
                                case 3:     vmostrarAmenu();
                                            $albumnes=mbuscaralbum($_GET['busqueda']);//album(disco)
                                            vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                            valbumborrar($albumnes);
                                            vmostrarAUsuario($_SESSION["admin"]);
                                            break;
                            }
                            break;
                case 3:     if (mborrarCancion($_GET['idcancion'])){
                                mostrarInfo("Cancion borrada correctamente");
                            }else{
                                mostrarError("Error al eliminar", "No se ha podido eliminar la cancion");
                                vmostrarAmenu();
                                vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                vmostrarAUsuario($_SESSION["admin"]);
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
            mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion");
		}
	}
	/////////////////////////////////////////////////////////////////////////
?>
