<?php

    function conexion()
    {
        include("globales.php");
        $con = mysql_connect($servidor, $usuario, $contraseña);
        $bd = mysql_select_db($basedatos, $con);
        mysql_set_charset('utf8');
        return $con;
    }
    
    function mLogin($uid, $pw)
    {
        $usuario = addslashes($uid);
        $contraseña = addslashes($pw);
        $con = conexion();
        $resultado = mysql_query("SELECT Usuario FROM usuarios WHERE Usuario COLLATE utf8_general_ci like '" . $usuario . "' and Contraseña='" . sha1($contraseña) . "'",$con) or die("Error en: " . mysql_error());
        $comprobacion = mysql_fetch_array($resultado);
        if ($comprobacion !==false )
        {
            return $comprobacion[0];
        }
        else
        {
            return false;
        }
    }
	
	function mCambiarcontraseña($uid,$pwa,$pw)
	{
		$con = conexion();
		$usuario = addslashes($uid);
        $contraseñaA = addslashes($pwa);
        $contraseña = addslashes($pw);
		$resultado = mysql_query("UPDATE usuarios SET Contraseña = " . sha1($contraseña) . " Usuario COLLATE utf8_general_ci like '" . $usuario . "' and Contraseña = '" . sha1($contraseñaA) . "'", $con);
		$resultado = mysql_affected_rows();
		if ($resultado != -1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function mBuscar($buscar,$tipo,$usuario)
	{
		$con = conexion();
		if (!isset($buscar) || !is_numeric($tipo)){
			return null;
		}
		$buscar=mysql_real_escape_string($buscar);
		switch($tipo)
		{
			case 0:		$resultado = mysql_query("select p.Id, p.Nombre, p.Asunto,(select count(*) from cancionesplaylist where playlist=p.id) Canciones , p.Usuario, p.Fecha, (p.ValoracionSemanal * 8) as ValoracionSemanal from playlist p where p.Nombre COLLATE utf8_general_ci like '%$buscar%' order by ValoracionSemanal desc limit 20",$con);
						break;
			case 1:		$resultado = mysql_query("select Id,Titulo,Artista,Album,(Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal,Año,Genero 
												from canciones c left join puntuacioncanciones p on p.Cancion = c.id and usuario = '$usuario' WHERE Titulo COLLATE utf8_general_ci like '%$buscar%' order by ValoracionSemanal desc limit 20",$con);
						break;
		}
		
		return $resultado;  
	}
	
	function mIToplistas()
	{
		$con = conexion();
		$resultado = mysql_query("select Id, p.Usuario, Nombre, Asunto, (select count(*) from cancionesplaylist where playlist=id) as Canciones, p.Fecha, (ValoracionSemanal * 8) as ValoracionSemanal from playlist p order by ValoracionSemanal desc limit 20",$con);
		return $resultado;   
	}
	
	function mToplistas($usuario)
	{
		$con = conexion();
		$resultado = mysql_query("select Id, p.Usuario, Nombre, Asunto, (select count(*) from cancionesplaylist where playlist=id) as Canciones, p.Fecha, (Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal from playlist p left join puntuacionesplaylist pp on id = playlist and pp.usuario = '$usuario' order by ValoracionSemanal desc limit 20",$con);
		return $resultado;   
	}
	
	function mToplistascancion($cid)
	{
		$con = conexion();
		$resultado = mysql_query("select p.Id, p.Nombre, p.Asunto, count(Cancion) as Canciones, p.Usuario, p.Fecha, (p.ValoracionSemanal * 8) as ValoracionSemanal from playlist p, cancionesplaylist c where p.id = c.playlist and c.cancion = '$cid' order by ValoracionSemanal desc limit 20",$con);
		return $resultado;   
	}
	
	function mITopcanciones()
	{
		$con = conexion();
		$resultado = mysql_query("select Id,Titulo,Artista,Album, (ValoracionSemanal * 8) as ValoracionSemanal,Año,Genero from canciones c order by ValoracionSemanal desc limit 20",$con);
		return $resultado;
	}
	
	function mTopcanciones($usuario)
	{
		$con = conexion();
		$resultado = mysql_query("select Id,Titulo,Artista,Album,(Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal,Año,Genero from canciones c left join puntuacioncanciones p on p.Cancion = c.id and usuario = '$usuario' order by ValoracionSemanal desc limit 20",$con);
		return $resultado;
	}
	
	function mMislistas($usuario)
	{
		$con = conexion();
		$resultado = mysql_query("select Id, Nombre, Asunto, (select count(*) from cancionesplaylist where playlist=id) as Canciones, p.Usuario, p.Fecha,(Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal from playlist p join puntuacionesplaylist pp on id = playlist and pp.usuario = '$usuario' and p.usuario = '$usuario' order by Valoracion desc limit 20",$con);
		return $resultado;   
	}
	
	function mMisfavoritos($usuario)
	{
        $con = conexion();
		$resultado = mysql_query("select Id, Titulo, Artista, Genero, Album, Año, (p.Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal from canciones c join puntuacioncanciones p on (id = Cancion) WHERE usuario = '$usuario' order by Valoracion desc limit 20",$con);
		return $resultado;
	}
	
	function mCancion($cid)
	{
		$con = conexion();
		$resultado = mysql_query("select Id, Titulo, Artista, Genero, Album, Año,ValoracionSemanal*8 Valoracion from canciones WHERE Id = '$cid'",$con);
                $aux=  mysql_fetch_assoc($resultado);
		return $aux;
	}

	function mReportes()
	{
            $con = conexion();
            $resultado=mysql_query("select Id, Usuario, Reportes, Comentario, Playlist, Ignorado from comentarios order by reportes limit 20;",$con);
            $i=0;
            $aux=null;
            if ($resultado!==false) {
                while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
                }
            }
            return $aux;     
	}
	
	function mUsuarios()
	{
		$con = conexion();
		$resultado=mysql_query("select  Usuario, Nombre, Apellido1, Apellido2, Correo from usuarios order by Usuario limit 20;",$con);
		return $resultado;   
	}
	
	function mCanciones()
	{
		$con = conexion();
		$resultado=mysql_query("select  Id, Titulo, Artista, Genero, Album, Año from canciones order by Id limit 20;",$con);
		return $resultado;   
	}
	
	function mPuntuacioncancion($id,$p,$usuario)
	{
		$con = conexion();
		$resultado1 = mysql_query("INSERT INTO puntuacioncanciones VALUES('$usuario', '$id', CURDATE(), '$p')",$con);
		if ($resultado1 === false)
		{
			$resultado1 = mysql_query("UPDATE puntuacioncanciones SET Valoracion = '$p' WHERE Cancion = '$id' and Usuario = '$usuario'",$con);	
		}
		$resultado2 = mysql_query("select (p.Valoracion * 8) as Valoracion from puntuacioncanciones p WHERE Cancion = '$id' and Usuario = '$usuario'",$con);
		return array ($resultado1, $resultado2);
	}
	
	function mPuntuacionplaylist($id,$p,$usuario)
	{
		$con = conexion();
		$resultado1 = mysql_query("INSERT INTO puntuacionesplaylist VALUES('$usuario', '$id', CURDATE(), '$p')",$con);
		if ($resultado1 === false)
		{
			$resultado1 = mysql_query("UPDATE puntuacionesplaylist SET Valoracion = '$p' WHERE Playlist = '$id' and Usuario = '$usuario'",$con);
		}
		$resultado2 = mysql_query("select (p.Valoracion * 8) as Valoracion from puntuacionesplaylist p WHERE Playlist = '$id' and Usuario = '$usuario'",$con);
		return array ($resultado1, $resultado2);
	}
	
	function mAlta($user,$nombre,$apellido1,$apellido2,$correo,$contraseña)
	{
		$con=conexion();
		$nombre=mysql_real_escape_string($nombre);
                $nombre=  htmlentities($nombre);
		$user=mysql_real_escape_string($user);
                $user=  htmlentities($user);
		$apellido1=mysql_real_escape_string($apellido1);
                $apellido1=htmlentities($apellido1);
		$apellido2=mysql_real_escape_string($apellido2);
                $apellido2=htmlentities($apellido2);
		$correo=mysql_real_escape_string($correo);
                $correo=htmlentities($correo);
		$contraseña=mysql_real_escape_string($contraseña);
		$cifrado=sha1($contraseña);
		$resultado=mysql_query("insert into usuarios(usuario,nombre,apellido1,apellido2,correo,contraseña) values ('$user','$nombre','$apellido1','$apellido2','$correo','$cifrado')",$con); 
		return $resultado;   
	}
    /////////////////////////////////////////////////////////////////
        function mIsAdmin($usuario){
            $con=conexion();
            $resultado=mysql_query("select usuario from Administradores where usuario=$usuario",$con);
            $isusuario = mysql_fetch_array($resultado);
            if ($isusuario==false){
                return false;
            }else{
                return true;
            }
        }
        function subirArchivo($archivo,$path,$nombre,$tamMaximo){
            if ($archivo['size']>$tamMaximo){
                return false;
            }
            $res= move_uploaded_file ($archivo['tmp_name'] ,$path.'/'.$nombre);
            return $res;
        }
        function adminlogin($admin,$contraseña){
            if (!isset($admin,$contraseña)){
                    return false;
            }
            $con=conexion();
            $admin=mysql_real_escape_string($admin);
            $contraseña=mysql_real_escape_string($contraseña);
            $cifrado=sha1($contraseña);
            $consulta="select usuario from administradores where contraseña='$cifrado' and usuario='$admin'";
            $resultado=mysql_query($consulta,$con);
            $fusuario = mysql_fetch_assoc($resultado);
            if ($fusuario==false) {        
                return false;
            }else{
                return $fusuario['usuario'];       
            }
        }
        function añadirCancion($titulo,$autor,$album,$genero,$año,$imagen,$cancion){
            if (!isset($titulo,$autor,$album,$genero,$año,$imagen,$cancion)){ //estan todos los datos
                return false;
            }
            $con=conexion();
            $titulo=mysql_real_escape_string($titulo);
            $titulo=htmlentities($titulo);
            $autor=mysql_real_escape_string($autor);
            $autor=htmlentities($autor);
            $album=mysql_real_escape_string($album);
            $album=htmlentities($album);
            $genero=mysql_real_escape_string($genero);
            $genero=htmlentities($genero);
            $año=mysql_real_escape_string($año);
            $año=htmlentities($año);
            mysql_query("begin",$con);
            $result=  mysql_query("insert into canciones(Titulo,Artista,Album,Genero,Año) values ('$titulo','$autor','$album','$genero','$año')",$con);
            if ($result===false){ //ya existe en la DB, no lo subimos de nuevo
                mysql_query("rollback",$con);
                return false;
            }
            $nomarchivo= mysql_insert_id();
            $ar1=subirArchivo($imagen, "./caratulas",$album.'.jpg',3000000);
            $ar1 &=imagejpeg($ar1,"./caratulas/$album.jpg",85); //cambiamos la imagen a jpg
            $ar2=subirArchivo($cancion, "./canciones",$nomarchivo.'.mp3',10000000);
            if ($ar1 ==true && $ar2==true){ //compruebo si se han subido los archivos
                mysql_query("commit",$con);//correcto, confirmo cambios
                return true;
            }else{ //fallo en la subida de archivos, desago el insert ¿borrar lo subido?
                mysql_query("rollback",$con);//tiramos pa atras
                return false;
            }
                
        }
     function mbuscartitulo($palabra){
        $con = conexion();
        $palabra=mysql_real_escape_string($palabra);
        $resultado = mysql_query("select * from canciones WHERE titulo like '%$palabra%'",$con);
        $i=0;
        $resultado = mysql_query("select * from canciones WHERE titulo like '%$palabra%'",$con);
        $i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux;   
     }
     function mbuscarautor($palabra){
        $con = conexion();
        $palabra=mysql_real_escape_string($palabra);
		$resultado = mysql_query("select Artista,count(distinct album) albumnes,count(id) canciones from canciones where Artista like '%$palabra%' group by Artista;",$con);
		$i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux;   
     }
    function mbuscaralbum($palabra){
        $con = conexion();
        $palabra=mysql_real_escape_string($palabra);
        $resultado = mysql_query("select Artista, album,count(id) canciones from canciones where album like '%$palabra%' group by album;",$con);
        $i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux;   
     }
     function mborrarCancion($id){
        $con = conexion();
        if (!is_numeric($id)){
            return false;
        }
        $resultado = mysql_query("SELECT album,count(id) 'n' from canciones where album=(select album from canciones where id='$id') group by album",$con);
        if ($resultado===false || mysql_num_rows($resultado)!=1) {
            return false;//no existe el id
        }
        $datos = mysql_fetch_assoc($resultado);
        mysql_free_result($resultado);
        $otro = mysql_query("delete from canciones where id='$id'",$con);
        if ($otro===false){
            return false;//no se ha podido eliminar la cancion
        }
        unlink("canciones/$id.mp3");//borramos la cancion
        if ($datos['n']==1){//es la ultima cancion del albun, asi que tambien borramos la caratula del album
              unlink("caratulas/".$datos['album'].".jpg");
        }
        return true;
     }
     function cancionesautor($autor){
        $con = conexion();
        $autor=mysql_real_escape_string($autor);
        $resultado = mysql_query("select Id,Titulo,Artista,Genero,Album,Año from canciones where Artista like '$autor'",$con);
        $i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux; 
     }
     function cancionesalbum($album){
        $con = conexion();
		$resultado = mysql_query("select * from canciones where album like '$album'",$con);
		$i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux; 
     }
     function mborrarCanciones($canciones){
        foreach ($canciones as $cancion){
            mborrarCancion($cancion['Id']);
        }
     }
     
    function mcancionesplaylist($id){
        $con=conexion();
        if (!is_numeric($id)){//nos la querian colar ¬¬
            return null;
        }
        $resultado=mysql_query("select  Id,Titulo,Artista,Album,Genero,Año,(ValoracionSemanal * 8) as ValoracionSemanal from canciones c join cancionesplaylist p on (p.cancion=c.id) where playlist=$id" ,$con);  
        $i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux; 
    }
     
     function minfoplaylist($id){
        $con=conexion();
        if (!is_numeric($id)){//nos la querian colar ¬¬
            return null;
        }
        $info=null;
        $resultado=mysql_query("SELECT Id,Usuario,Nombre,Asunto,Descripcion,Fecha,(ValoracionSemanal * 8) as ValoracionSemanal FROM `playlist` WHERE id='$id'",$con);
        if ($resultado !== false) {
            $info = mysql_fetch_assoc($resultado);
        }
        return $info;
    } 
    
    function mcomplaylist($id,$pag=1){
        $con=conexion();
        if (!is_numeric($id) || !is_numeric($pag)){//nos la querian colar ¬¬
            return null;
        }
        $empieza=($pag-1)*20;
        $resultado=mysql_query("select Id,Usuario,Comentario from comentarios where playlist='$id' limit $empieza,20" ,$con);  
        $i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($cancion = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$cancion;
                $i++;
            }
        }
        return $aux;    
    }
    function mpublicarComentario($uid,$pid,$comentario){
        if (!is_numeric($pid) || !is_string($comentario)){
            return false;
        }
        $con=conexion();
        $comentario=htmlentities($comentario,ENT_SUBSTITUTE);
        $comentario=mysql_real_escape_string($comentario);
        $resultado=mysql_query("insert into comentarios(Usuario,Playlist,Comentario) values ('$uid','$pid','$comentario') " ,$con); 
        if ($resultado!==false){
            return true;
        }else{
            return false;
        }
    } 
    function mobtenerReportes(){
        $con = conexion();
	$resultado = mysql_query("select Id,Usuario,Comentario,Reportes from comentarios where ignorado='0' and Reportes>'0' order by reportes desc",$con);
	$i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($reporte = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$reporte;
                $i++;
            }
        }
        return $aux; 
     }
    function mobtenerReportesIgnorados(){
        $con = conexion();
	$resultado = mysql_query("select Id,Usuario,Comentario from comentarios where ignorado=1 order by reportes desc",$con);
	$i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($reporte = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$reporte;
                $i++;
            }
        }
        return $aux; 
     }     
    function mignorar($id){
        $con = conexion();
        if (!is_numeric($id)){
            return false;
        }
	mysql_query("update comentarios set Ignorado='1' where Id='$id'",$con);
     }
     function mborrarComentario($id){
        $con = conexion();
        if (!is_numeric($id)){
            return false;
        }
        $otro = mysql_query("delete from comentarios where id='$id'",$con);
        if ($otro===false){
            return false;
        }else{
            return true;
        }
    }
    function mcrearPlaylist($usuario,$titulo,$asunto,$descripcion){
        $con=conexion();
        if (!isset($usuario,$titulo,$asunto,$descripcion)){
            return false;
        }
        $usuario=mysql_real_escape_string($usuario);
        $titulo=mysql_real_escape_string($titulo);
        $titulo=htmlentities($titulo);
        $asunto=mysql_real_escape_string($asunto);
        $asunto= htmlentities($asunto);
        $descripcion=mysql_real_escape_string($descripcion);
        $descripcion= htmlentities($descripcion);
        $resultado=mysql_query("insert into playlist(Usuario,Nombre,Asunto,Descripcion) values ('$usuario','$titulo','$asunto','$descripcion') " ,$con); 
        if ($resultado!==false){
            return true;
        }else{
            return false;
        }
    }
    function mactualizarPlaylist($pid,$titulo,$asunto,$descrip){
        $con=conexion();
        if ($_SESSION['usuario']!=mcreadorPlaylist($pid)){//el que modifica la playlist no es el autor
            return false;
        }
        $titulo=mysql_real_escape_string($titulo);
        $titulo= htmlentities($titulo);
        $asunto=mysql_real_escape_string($asunto);
        $asunto=  htmlentities($asunto);
        $descrip=mysql_real_escape_string($descrip);
        $descrip=  htmlentities($descrip);
        $resultado=mysql_query("update playlist set Nombre='$titulo',Asunto='$asunto',Descripcion='$descrip'where id='$pid' " ,$con); 
        if ($resultado!==false){
            return true;
        }else{
            return false;
        }
    }
    
    
    function mcreadorPlaylist($pid){
        $con=conexion();
        if (!is_numeric($pid)){
            return false;
        }
        $resultado = mysql_query("select Usuario from playlist where id='$pid'",$con);
        $i=0;
        $aux=mysql_fetch_assoc($resultado);
        if ($aux!=false)
            return $aux['Usuario'];
        else
            return false;
    }
    function mañadirCancionPlaylist($cid,$pid){
        $con=conexion();
        if (!is_numeric($cid) || !is_numeric($pid) || $_SESSION['usuario']!=mcreadorPlaylist($pid)){
            return false;
        }
        $resultado = mysql_query("insert into cancionesplaylist(playlist,cancion) values ('$pid','$cid')",$con);
        if ($resultado !== false) {
            return true;
        }else{
            return false;
        }    
    }
    function mquitarCancionPlaylist($cid,$pid){
        $con=conexion();
        if (!is_numeric($cid) || !is_numeric($pid) || $_SESSION['usuario']!=mcreadorPlaylist($pid)){
            return false;
        } 
        $resultado = mysql_query("delete from cancionesplaylist where playlist='$pid' and cancion='$cid'",$con);
        if ($resultado !== false) {
            return true;
        }else{
            return false;
        }   
    }
    function mobtenerPlaylist($uid){
        $con=conexion();
        $uid=mysql_real_escape_string($uid);
        $resultado = mysql_query("select Nombre,Id from playlist where Usuario='$uid' order by Nombre",$con);
        $i=0;
        $aux=null;
        if ($resultado!==false) {
            while ($reporte = mysql_fetch_assoc($resultado)) {
                $aux[$i]=$reporte;
                $i++;
            }
        }
        return $aux; 
    }
    function mnumcomplaylist($pid){
        $con=conexion();
        if (!is_numeric($pid)){//nos la querian colar ¬¬
            return null;
        }
        $resultado=mysql_query("select count(*) num from comentarios where playlist='$pid'" ,$con);  
        $num=0;
        if ($resultado!==false) {
            $aux = mysql_fetch_assoc($resultado);
            $num=$aux['num'];
        }
        return $num;   
    }
    
    function mborrarUsuario($uid){
        $con=conexion();
        if (!isset($uid)){
            return false;
        }
        $uid=mysql_real_escape_string($uid);
        $resultado=mysql_query("delete from usuarios where Usuario='$uid'" ,$con);  
         if ($resultado!==false) {
            return true;
        }else{
            return false;
        } 
    }
    function mactualizar(){
        $con=conexion();
        $resultado=mysql_query("CALL `ACTUALIZAR`();",$con);  
         if ($resultado!==false) {
            return true;
        }else{
            return false;
        } 
    }
    function meliminarPlaylist($pid,$uid){
        if (!is_numeric($pid)||!is_numeric($uid)){
            return false;
        }
        if (!($uid==mcreadorPlaylist($pid))){//no es el creador de la playlist
            return false;
        }
        $con=conexion();
        $resultado=mysql_query("delete from playlist where Id='$pid'" ,$con);  
         if ($resultado!==false) {
            return true;
        }else{
            return false;
        } 
    }
?>
