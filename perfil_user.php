<?php
require_once __DIR__ .'/includes/config.php';
require_once __DIR__ .'/includes/usuarioUtils.php';

$usuario = null;
if(isset($_GET['id']) && $_GET['id']!=null){
	$idUser = $_GET['id'];
	$usuario = es\ucm\fdi\aw\Usuario::buscaPorID_usuario($idUser);
}
else if(estaLogado()){
    $idUser = idUsuarioLogado();
    if($idUser != false){ // comprobamos si hemos recibido un id de usuario
        $usuario = es\ucm\fdi\aw\Usuario::buscaPorID_usuario($idUser); // funcion estática para buscar en la base de datos al usuario por el dni
	}
}	
$esMiPerfil = false;
$tituloPagina = 'PerfilUsuario';
$contenidoPrincipal = '<link rel="stylesheet" type="text/css" href="perfil.css" />';

if($usuario != null){ // comprobamos si el usuario esta en la base de datos
	if ($usuario->getID() == idUsuarioLogado() || permisosVoluntario()) $esMiPerfil = true;
    // aqui iria el div para foto nombre y apellido
    $contenidoPrincipal.= "<div id='perfilcontenedor'>";
    $contenidoPrincipal .= "<div id='contenedorNombre'>";
    $contenidoPrincipal .= "<div id='contenedorImagen'>";
    if(file_exists(FICHERO_IMGUSU.'/'.$usuario->getID().'.jpg')){
		$contenidoPrincipal .= "<img class='perfilUser' src=img/usu/".$usuario->getID().".jpg alt=Foto usuario".$usuario->getID()."/>";
		if($esMiPerfil || permisosVoluntario()){
            $contenidoPrincipal .= "<div id='cambiarFotoContenedor'>";
			$contenidoPrincipal .="<p>Cambiar foto:</p>";
			$form = new es\ucm\fdi\aw\FormularioFotoUsu($usuario->getID());
			$contenidoPrincipal .= $form->gestiona();
            $contenidoPrincipal .= "</div>";
		}
	}else{
		$contenidoPrincipal .= "<img class='perfilUser' src=img/usu/null.jpg alt=Foto usuario".$usuario->getID()."/>";
        $contenidoPrincipal .= "<div id='cambiarFotoContenedor'>";
        if($esMiPerfil || permisosVoluntario()){
			$contenidoPrincipal .="<p>Añadir foto:</p>";
			$form = new es\ucm\fdi\aw\FormularioFotoUsu($usuario->getID());
			$contenidoPrincipal .= $form->gestiona();
            $contenidoPrincipal .= "</div>";
		}
	}
    $contenidoPrincipal .= "</div>";
    $contenidoPrincipal .= "<div id='contenedorNameApellido'>";
	
	
    $contenidoPrincipal .="<p> ".$usuario->getNombre(). "</p>";
	$contenidoPrincipal .="<p> ".$usuario->getApellido(). "</p>";
    
    $contenidoPrincipal .= "</div>";
    $contenidoPrincipal .= "</div>";
    // contenedor con el resto de datos
    $contenidoPrincipal .= "<div id='contenedorDatos'>";
    $contenidoPrincipal .= "<div id='contenedorDatosIzquierda'>";
    if ($esMiPerfil)$contenidoPrincipal .="<p> DNI: ".$usuario->getDni(). "</p>";
    if ($esMiPerfil)$contenidoPrincipal .= "<p> TELEFONO: ".$usuario->getTelefono(). "</p>";
    if ($esMiPerfil)$contenidoPrincipal .= "<p> EMAIL: ".$usuario->getEmail(). "</p>";
    $contenidoPrincipal .= "<p> FECHA NACIMIENTO : ".$usuario->getNacimiento(). "</p>";
    if ($esMiPerfil)$contenidoPrincipal .= "<p> DIRECCION: ".$usuario->getDireccion(). "</p>";
    $contenidoPrincipal .= "<p> TIPO: ".$usuario->getTipo(). "</p>";
	if(permisosAdministrador()){
		
		$form = new es\ucm\fdi\aw\FormularioAscension($idUser);
		$htmlFormAscension = $form->gestiona();
		
		$contenidoPrincipal .= "$htmlFormAscension";
	}
    $contenidoPrincipal .= "</div>";
    //animales adoptados y apadrinados
	if ($esMiPerfil || permisosVoluntario()){
    $contenidoPrincipal .= "<div id='contenedorDatosDerecha'>";
	$contenidoPrincipal .= "<p> ANIMALES EN PROCESO:" ."</p>";
	$contratos = es\ucm\fdi\aw\Contrato::getContratosID($idUser);
	foreach($contratos as $i){
		$animal = es\ucm\fdi\aw\Animal::buscaPorID($i->getId());
		$idAnimal = $animal->getId();
		$contenidoPrincipal .=  "<a class='boton' href=solicitud.php?idAni={$idAnimal}&idUsu={$idUser}>".$animal->getNombre().' - '.$i->getEstado(). "</a>";
	}
    $adoptado = es\ucm\fdi\aw\Animal::getAdoptados($usuario->getID());
    $contenidoPrincipal .= "<p> ANIMALES ADOPTADOS:" ."</p>";
    if($adoptado != false){
        foreach($adoptado as $i){ 
            $animal = $i->getID();
			$contenidoPrincipal .=   "<a class='boton' href=perfil_animal.php?id={$animal}>".$i->getNombre(). "</a>";
        }
    } else $contenidoPrincipal .= "<p> Ninguno </p>";			
    $apadrinado = es\ucm\fdi\aw\Animal::getApadrinados($usuario->getID());
    $contenidoPrincipal .="<p> ANIMALES APADRINADOS:" ."</p>";
    if($apadrinado != false){
        foreach($apadrinado as $i){ 
            $animal = $i->getID();
			$contenidoPrincipal .=   "<a class='boton' href=perfil_animal.php?id={$animal}>".$i->getNombre(). "</a>";
        }
    } else $contenidoPrincipal .= "<p> Ninguno </p>";
    $contenidoPrincipal .= "</div>";
    $contenidoPrincipal .= "</div>";
	}
	if($usuario->getID() == idUsuarioLogado()){
		$contenidoPrincipal .= "<div id='botonesContenedor'>";
		$contenidoPrincipal .= <<<EOS
		<a class='boton' href=editarPerfilUsuario.php> Editar perfil</a>
EOS;
        $contenidoPrincipal .= "</div>";
    }
}
else{
    $contenidoPrincipal .= "<h2>No hay ningun usuario</h2>";
}

$contenidoPrincipal .= "</div>";
 require __DIR__ . '/includes/plantillas/plantilla.php';
