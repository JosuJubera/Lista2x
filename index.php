<?php
    include("modelo.php");
    include("vista.php");

	$accion = "TL";
	$id = 1;

	session_start();
    if (isset($_SESSION['admin'])){
        $accion="AR";
        $id=1;
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
    
    if(isset($_POST["uid"],$_POST["pw"])) //preguntar si debe de ir con un action y un id
    {
        $uid = $_POST["uid"];
        $pw = $_POST["pw"];
        $usuario = mLogin($uid, $pw);
		if ($usuario != false)
		{
			$_SESSION["usuario"] = $usuario;
		}	
    }
	
	if ($accion == "REC")
	{
		vmostrarRecuperar();
		vmostrarContactar();
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
        ////////////////////////////////////////////////////////////////////////
        if ($accion=="admin"){//login admin
            switch ($id){
                case 2:$nombre=adminlogin($_POST['aid'], $_POST['apw']);
                    if ($nombre!==false){
                        $_SESSION['admin']=$nombre;
                        vmostrarAmenu();//aqui iria el menu principal
                    }else{//error ususario incorrecto
                        vloginadmin();
                    }
                    break;
                default:vloginadmin();
            }
        }
        if ($accion== "AR"){ //administrar reportes
             if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){
                 switch ($id){
                    case 1: vmostrarAmenu(); //mostrar reportes
                            break;
                    case 2://borrar comentario
                    default:vmostrarAmenu();
                }
             }else{
                 echo "no eres admin";
             }
        }
        if ($accion == "AC"){//alta cancion
            if (isset($_SESSION["admin"]) /*&& mIsAdmin($_SESSION["admin"])*/){ //es un admin
                switch ($id){
                    case 1: valtaCancion(); //mostrar el formulario
                            break;
                    case 2:if (añadirCancion($_POST['titulo'], $_POST['autor'], $_POST['album'], $_POST['genero'], $_POST['año'], $_FILES["caratula"],$_FILES["cancion"])){
                                //exito, añadido. mostrar mensaje y pa dejar pa añadir otra
                                echo "cancion añadida con exito";
                                vmostrarAmenu();
                            }else{
                                //fallo, enviar mensajede fallo y k vuelva a intentarlo
                                echo "fallo";
                                valtacancion();
                            }
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
                            case 2:$autores=  mbuscarautor($_GET['busqueda']);
                                vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                vautorborrar($autores);
                                break;
                            case 3:$albumnes=mbuscaralbum($_GET['busqueda']);//album(disco)
                                vbuscarborrar($_GET['busqueda'],$_GET['buscar']);
                                valbumborrar($albumnes);
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
                    case 5:$cancionesaborrar=cancionesalbum($_GET['album']);//confirmar borrar disco
                            $_SESSION['cancionesborrar']=$cancionesaborrar;
                            vmostrarconfirmacion($cancionesaborrar);
                    case 6://eliminar canciones
                }
            }else{
                echo "necesitas ser administrador";
            }
        }
	/////////////////////////////////////////////////////////////////////////
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
            vmostrarRmenu();
        }
		$datos = mTopcanciones();
		vmostrarTopcanciones($datos);
		vmostrarContactar();
    }
	
	if (($accion == "ML") and (isset($_SESSION["usuario"])))
	{
		vmostrarUsuario($_SESSION["usuario"]);
        vmostrarRmenu();
		$datos = mMislistas($_SESSION["usuario"]);
		vmostrarMislistas($datos);
		vmostrarContactar();
	}
	
	if (($accion == "MF") and (isset($_SESSION["usuario"])))
	{
		vmostrarUsuario($_SESSION["usuario"]);
                vmostrarRmenu();
		$datos = mMisfavoritos($_SESSION["usuario"]);
		vmostrarMisfavoritos($datos);
		vmostrarContactar();
	}
?>