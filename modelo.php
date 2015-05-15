<?php
/* dudas:
 * obtener valoracion semanal de canciones/playlist
 * limpiar datos antes de llamar a la db o hacerlo en el controlador?
 */

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
        $resultado = mysql_query("SELECT count(Usuario) FROM usuarios WHERE Usuario='" . $usuario . "' and Contraseña='" . sha1($contraseña) . "'",$con) or die("Error en: " . mysql_error());
		$comprobacion = mysql_fetch_array($resultado);
        if ($comprobacion[0] == 1)
        {
            return $usuario;
        }
        else
        {
            return false;
        }
    }
	
	function mBuscar($buscar,$tipo)
	{
		$con = conexion();
		switch($tipo)
		{
			case 0:		$resultado = mysql_query("select p.Id, p.Nombre, p.Asunto, count(Cancion) as Canciones, p.Usuario, p.Fecha, (p.ValoracionSemanal * 8) as ValoracionSemanal from playlist p, cancionesplaylist c where p.id = c.playlist and p.Nombre COLLATE utf8_general_ci like '%$buscar%' order by ValoracionSemanal desc limit 20",$con);
						break;
			case 1:		$resultado = mysql_query("select Id, Titulo, Artista, Genero, Album, Año, (ValoracionSemanal * 8) as ValoracionSemanal from canciones where Titulo COLLATE utf8_general_ci like '%$buscar%' or Artista COLLATE utf8_general_ci like '%$buscar%' or Album COLLATE utf8_general_ci like '%$buscar%' order by ValoracionSemanal desc limit 20;",$con);
						break;
		}
		return $resultado;
	}
	
	function mToplistas()
	{
		$con = conexion();
		$resultado = mysql_query("select p.Id, p.Nombre, p.Asunto, count(Cancion) as Canciones, p.Usuario, p.Fecha, (p.ValoracionSemanal * 8) as ValoracionSemanal from playlist p, cancionesplaylist c where p.id = c.playlist order by ValoracionSemanal desc limit 20",$con);
		return $resultado;   
	}
	
	function mToplistascancion($cid)
	{
		$con = conexion();
		$resultado = mysql_query("select p.Id, p.Nombre, p.Asunto, count(Cancion) as Canciones, p.Usuario, p.Fecha, (p.ValoracionSemanal * 8) as ValoracionSemanal from playlist p, cancionesplaylist c where p.id = c.playlist and c.cancion = '$cid' order by ValoracionSemanal desc limit 20",$con);
		return $resultado;   
	}
	
	function mTopcanciones($usuario)
	{
		$con = conexion();
		$resultado = mysql_query("select Id, Titulo, Artista, Genero, Album, Año, (p.Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal from canciones c left join puntuacioncanciones p on (id = Cancion) WHERE usuario = '$usuario' order by ValoracionSemanal desc limit 20;",$con);
		return $resultado;
	}
	
	function mMislistas($usuario)
	{
		$con = conexion();
		$resultado = mysql_query("select p.Id, p.Nombre, p.Asunto, count(Cancion) as Canciones, p.Usuario, p.Fecha, (p.Valoracion * 8) as Valoracion from playlist p, cancionesplaylist c WHERE p.id = c.playlist order by valoracion desc limit 20",$con);
		return $resultado;   
	}
	
	function mMisfavoritos($usuario)
	{
		$con = conexion();
		$resultado = mysql_query("select Id, Titulo, Artista, Genero, Album, Año, (p.Valoracion * 8) as Valoracion, (ValoracionSemanal * 8) as ValoracionSemanal from canciones c join puntuacioncanciones p on (id = Cancion) WHERE usuario = '$usuario' order by Valoracion desc limit 20;",$con);
		return $resultado;
	}
	
	function mCancion($cid)
	{
		$con = conexion();
		$resultado = mysql_query("select Id, Titulo, Artista, Genero, Album, Año from canciones WHERE Id = '$cid'",$con);
		return $resultado;
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
	
	function altausuario($nombre,$apodo,$correo,$ucontraseña)
	{
		$con=conexion();
		mysql_real_escape_string($nombre);
		mysql_real_escape_string($apodo);
		mysql_real_escape_string($correo);
		mysql_real_escape_string($ucontraseña);
		$cifrado=sha1($ucontraseña);
		$resultado=mysql_query("insert into usuarios(nombre,usuario,correo,contraseña) values ('$nombre','$apodo','$correo','$cifrado');",$con); 
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
        function subirArchivo($archivo,$path,$nombre,$extension,$tamMaximo){
            if ($archivo['size']>$tamMaximo/* || !substr_compare($archivo['name'],$extension, strlen($archivo['name'])-3,3,true)*/){
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
            mysql_real_escape_string($admin);
            mysql_real_escape_string($contraseña);
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
            mysql_real_escape_string($titulo);
            mysql_real_escape_string($autor);
            mysql_real_escape_string($album);
            mysql_real_escape_string($genero);
            mysql_real_escape_string($año);
            mysql_query("begin",$con);
            $result=  mysql_query("insert into canciones(Titulo,Autor,Album,Genero,Año) values ('$titulo','$autor','$album','$genero','$año')",$con);
            if ($result===false){ //ya existe en la DB, no lo subimos de nuevo
                mysql_query("rollback",$con);
                return false;
            }
            $nomarchivo= mysql_insert_id();
            $ar1=subirArchivo($imagen, "./caratulas",$album.'.jpg', 'jpg',3000000);
            $ar2=subirArchivo($cancion, "./canciones",$nomarchivo.'.mp3', 'mp3',10000000);
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
        mysql_real_escape_string($palabra);
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
        mysql_real_escape_string($palabra);
		$resultado = mysql_query("select autor,count(distinct album) albumnes,count(id) canciones from canciones where autor like '%$palabra%' group by autor;",$con);
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
        mysql_real_escape_string($palabra);
		$resultado = mysql_query("select autor, album,count(id) canciones from canciones where album like '%$palabra%' group by album;",$con);
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
        if (!isset($id)){
            return false;
        }
        mysql_real_escape_string($id);
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
		$resultado = mysql_query("select * from canciones where autor like '$autor'",$con);
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
         $i=0;
         $j=0;
         $sinborrar=null;
         while($i<count($canciones)){
             if (!mborrarCancion($canciones[$i])){
                 $sinborrar[$j]=$canciones[$i];
                 $j++;
             }
             $i++;
         }
         return true;
     }
     
    function mcancionesplaylist($id){
        $con=conexion();
        if (!is_numeric($id)){//nos la querian colar ¬¬
            return null;
        }
        $resultado=mysql_query("select  Id,Titulo,Artista,Album,Genero,(ValoracionSemanal * 8) as ValoracionSemanal from canciones c join cancionesplaylist p on (p.cancion=c.$id) where playlist=1" ,$con);  
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
    
    function mcomplaylist($id){
        $con=conexion();
        if (!is_numeric($id)){//nos la querian colar ¬¬
            return null;
        }
        $resultado=mysql_query("select Id,Usuario,Comentario from comentarios where playlist='$id';" ,$con);  
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
        mysql_real_escape_string($comentario);
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
        mysql_escape_string($id);
	mysql_query("update comentarios set Ignorado='1' where Id='$id'",$con);
     }
     function mborrarComentario($id){
        $con = conexion();
        mysql_escape_string($id);
        $otro = mysql_query("delete from comentarios where id='$id'",$con);
        if ($otro===false){
            return false;
        }else{
            return true;
        }
    }
?>
