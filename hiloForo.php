<?php
require_once __DIR__.'/includes/config.php';
require_once ("includes/usuarioUtils.php");

$tituloPagina = 'Hilo';
$contenidoPrincipal = "";

if(isset($_GET['hilo'])){
	$id_hilo = $_GET['hilo'];
	$hilo = es\ucm\fdi\aw\Hilo::getHilo($id_hilo);
	if ($hilo != null){
		
		$autor=es\ucm\fdi\aw\Usuario::buscaPorID_usuario($hilo->getID_usuario());
		$nombreAutor=$autor->getNombre();
		$apellidoAutor= $autor->getApellido();
		$idAutor=$hilo->getID_usuario();
		$comentarioAutor=$hilo->getComentario();
		$fechaAutor=$hilo->getFecha();
		$tituloHilo = $hilo->getTitulo();
		$srcIMGAutor=srcUsuarioIMG($idAutor);
		$irForo = "<h3><a href=foro.php> << Ir al Foro </a></h3>";
		$comienzoHilo = <<<EOS
			<h1 class="titulo"> HILO </h1>
			<h2 class="tituloHilo">$tituloHilo</h2>
			<div class="row">
					<div class="cabeceraHiloIMG" ><a href = "perfil_user.php?id=$idAutor"> <img class='perfilForo' src=$srcIMGAutor /> </a> </div> 
					<div class="columnEntrada">
						<div class="row"> <p><a href = "perfil_user.php?id=$idAutor"> $nombreAutor $apellidoAutor </a> ha dicho:  </p>  </div>
							 
						<div class="comentario"> <div><p> $comentarioAutor </p></div> </div>
					</div>
					
				</div>	
EOS;
		
		$entradas=es\ucm\fdi\aw\Entrada::getEntradasPorHilo($id_hilo);
		if($entradas != null)$cantEntradas = count($entradas); 
		else $cantEntradas=0;
		$i = 0;
		$respuestas = "";
		for($i = 0; $i < $cantEntradas; $i++){
			$usuario=es\ucm\fdi\aw\Usuario::buscaPorID_usuario($entradas[$i]->getID_usuario());
			$nombreUsuario=$usuario->getNombre();
			$apellidoUsuario= $usuario->getApellido();
			$idUsuario=$usuario->getID();
			$comentarioUsuario=$entradas[$i]->getComentario();
			$fechaUsuario=$entradas[$i]->getFecha();
			$srcIMG = srcUsuarioIMG($idUsuario);
			$respuestas.=<<<EOS
			<hr>
				<div class="row">
						 <div class="cabeceraHiloIMG" ><a href = "perfil_user.php?id=$idUsuario"> <img class='perfilForo' src=$srcIMG /> </a> </div> 
					<div class="columnEntrada">
						<div class="row"> <p><a href = "perfil_user.php?id=$idUsuario"> $nombreUsuario $apellidoUsuario </a> ha dicho:  </p>  </div>
							 
						<div class="comentario"> <div><p> $comentarioUsuario </p></div> </div>
					</div>
					
				</div>					
EOS;
		}
		
		$formNuevaEntrada = new es\ucm\fdi\aw\FormularioEntrada(idUsuarioLogado(), $id_hilo);
		$htmlform = $formNuevaEntrada->gestiona();	
		
		$contenidoPrincipal=<<<EOS
			$irForo
			$comienzoHilo	
			$respuestas
			$htmlform
			$irForo
EOS;
		
	}else $contenidoPrincipal = "<h1> ERROR CON EL HILO </h1>";
}
else{
	$contenidoPrincipal = <<<EOS
	<h1>No se está pasando el numero del hilo</h1>
EOS;
}

require __DIR__.'/includes/plantillas/plantilla.php';

/*
			<div>
				<div>
					<p> <a href = "perfil_user.php?id=$idAutor">$nombreAutor $apellidoAutor</a> ha dicho: </p>
				</div>
				<div>
					<p> $comentarioAutor </p>
				</div>
			</div>
*/
