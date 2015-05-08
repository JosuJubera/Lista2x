<?php
    include("modelo.php");
    include("vista.php");

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
	
	if ($accion == "CC")
	{
		vmostrarPreferencias();
		vmostrarCambiocontraseña();
		vmostrarContactar();
	}
	
	if ($accion == "CE")
	{
		vmostrarPreferencias();
		vmostrarCambiocorreo();
		vmostrarContactar();
	}
	
	if ($accion == "EC")
	{
		vmostrarPreferencias();
		vmostrarEliminarcuenta();
		vmostrarContactar();
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
	
	if ($accion=="admin"){//login admin
            switch ($id){
                case 2:$nombre=adminlogin($_POST['aid'], $_POST['apw']);
                    if ($nombre!=false){
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
                vmostrarAmenu();
                switch ($id){
                    case 1: //mostrar reportes
                            if (isset($_GET['verignorados'])&& $_GET['verignorados']==1){//mostramos los reportes ignorados por el admin anteriormente
                                $ignorados=  mobtenerReportesIgnorados();
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
                mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion");
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
                mostrarError("Acceso denegado", "Usted no tiene permisos para ver esta seccion");
            }
	}
?>