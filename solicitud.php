<?php 
	namespace es\ucm\fdi\aw;
	require_once __DIR__.'/includes/config.php';
	require_once __DIR__.'/includes/usuarioUtils.php';
	
	if (!isset($_GET['idAni']) || !isset($_GET['idUsu']) || !estaLogado() || ($_GET['idUsu']!= idUsuarioLogado() && !permisosVoluntario() )) $contenidoPrincipal = "<h1> NO TIENES PERMISOS PARA ENTRAR AQUÍ </h1>";
	else{
	
		$idAni = $_GET['idAni'];
		$idUsu = $_GET['idUsu'];
		
		$tituloPagina = "Solicitud";
		
		$contract = Contrato::buscaPorIDeID($idUsu, $idAni);
		$animal = Animal::buscaPorID($idAni);
		$usuario = Usuario::buscaPorID_usuario($idUsu);

		$contenidoPrincipal = '<h3>Estado de la solicitud: '.$contract->getEstado().'</h3>';
		$contenidoPrincipal .= '<h3>Nombre del usuario: '.$usuario->getNombre().' '.$usuario->getApellido().'</h3>';
		$contenidoPrincipal .= '<h3>Nombre animal: <a href = "perfil_animal.php?id='.$idAni.'">'.$animal->getNombre().'</a></h3>';
		$contenidoPrincipal .= '<h3>Formulario enviado: '.$contract->getFormulario().'</h3>';
		$contenidoPrincipal .= '<h3>Fecha de la solicitud: '.$contract->getFecha().'</h3>';
		
		$entradas=EntradaContrato::getEntradasPorContrato($idAni,$idUsu);
		if($entradas != null)$cantEntradas = count($entradas); 
		else $cantEntradas=0;
		$respuestas = "";
		for($i = 0; $i < $cantEntradas; $i++){
			$usuario=Usuario::buscaPorID_usuario($entradas[$i]->getID_autor());
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
		
		$formNuevaEntrada = new FormularioEntradaContrato($idAni, $idUsu,idUsuarioLogado());
		$htmlform = $formNuevaEntrada->gestiona();	
		
		if(permisosVoluntario()){
			
			$form = new FormularioCambio($idAni,$idUsu);
			$htmlFormCambio = $form->gestiona();
			
			$contenidoPrincipal .=<<<EOS
			$htmlFormCambio
			$respuestas
			$htmlform
EOS;

		}
		else {
			$contenidoPrincipal .=<<<EOS
			$respuestas
			$htmlform
EOS;	
		}
	}
	require __DIR__.'/includes/plantillas/plantilla.php';
?>
