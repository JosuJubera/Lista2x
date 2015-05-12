<?php
    include("modelo.php");
    include("vista.php");
//mirar: orden de las canciones en la playlist, lo guardamos o que cada una salga como quiera 
//al mostrar la playlist?
    //algun sistema de path o algo? que si no la navegacion es dificil.
    //tras añadir un comentario, no se puede recargar la pagina ¿Como arreglar eso?
    
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
	
	if (($accion == "CC") and (isset($_SESSION["usuario"])))
	{
		vmostrarPreferencias();
		vmostrarCambiocontraseña();
		vmostrarContactar();
	}
	
	if (($accion == "CE") and (isset($_SESSION["usuario"])))
	{
		vmostrarPreferencias();
		vmostrarCambiocorreo();
		vmostrarContactar();
	}
	
	if (($accion == "EC") and (isset($_SESSION["usuario"])))
	{
		vmostrarPreferencias();
		vmostrarEliminarcuenta();
		vmostrarContactar();
	}
	
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
	
	if ($accion == "OUT")
	{
		session_destroy();
		vmostrarLogin();
        vmostrarImenu();
		$datos = mToplistas();
        vmostrarToplistas($datos);
		vmostrarContactar();
	}
	
	if ($accion == "C")
	{
		vmostrarContacto();
	}
	
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
        $datos = mToplistas();
        vmostrarToplistas($datos);
		vmostrarContactar();
    }

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
		$datos = mTopcanciones();
		vmostrarTopcanciones($datos);
		vmostrarContactar();
    }
	
	if (($accion == "ML") and (isset($_SESSION["usuario"])))
	{
		vmostrarUsuario($_SESSION["usuario"]);
		vmostrarBuscardor();
        vmostrarRmenu();
		$datos = mMislistas($_SESSION["usuario"]);
		vmostrarMislistas($datos);
		vmostrarContactar();
	}
	
	if (($accion == "MF") and (isset($_SESSION["usuario"])))
	{
		vmostrarUsuario($_SESSION["usuario"]);
		vmostrarBuscardor();
        vmostrarRmenu();
		$datos = mMisfavoritos($_SESSION["usuario"]);
		vmostrarMisfavoritos($datos);
		vmostrarContactar();
	}
	
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
        
	if ($accion=="PC"){
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
	
	if($accion == "VC")
    {
        switch ($id)
		{
			case 1:		if (!isset($_SESSION["usuario"]))
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
			case 2:		if (!isset($_SESSION["admin"]))
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
        vmostrarCancion($datos1,$datos2);
		vmostrarContactar();
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
			 switch ($id){
				case 1: 	vmostrarAmenu(); //mostrar reportes
							$datos = mReportes();
							vmostrarReportes($datos);
							vmostrarUsuario($_SESSION["admin"]);
							break;
				case 2:		//borrar comentario
				default:	vmostrarAmenu();
			}
		 }else{
			 echo "no eres admin";
		 }
	}
	
	if ($accion== "AU"){ //administrar usuarios
		 if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){
			 switch ($id){
				case 1: 	vmostrarAmenu(); //mostrar usuarios
							$datos = mUsuarios();
							vmostrarUsuarios($datos);
							vmostrarUsuario($_SESSION["admin"]);
							break;
				case 2:		//borrar comentario
				default:	vmostrarAmenu();
			}
		 }else{
			 echo "no eres admin";
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
