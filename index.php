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

    if(isset($_GET["id"]))
    {
         $id = $_GET["id"];
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
	
	if ($accion == "PREF")
	{
		vmostrarPreferencias();
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
						case 2://autor
						case 3://disco
					}
					break;
				case 3: if (mborrarCancion($_GET['idcancion']))
							echo "eliminado con exito";
						else
							echo 'fallo al eliminar';
					break;
				case 4://eliminar disco
				case 5://eliminar album
				case 6://comfirmar
			}
		}else{
			echo "necesitas ser administrador";
		}
	}
	/////////////////////////////////////////////////////////////////////////
?>