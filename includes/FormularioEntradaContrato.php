<?php
	namespace es\ucm\fdi\aw;
	require_once "usuarioUtils.php";
	
	class FormularioEntradaContrato extends Form {
		
		private $idAni;
		private $idUsu;
		private $idAutor;
		
		public function __construct($idAni,$idUsu,$idAutor) {
			
			$this->idAni = $idAni;
			$this->idUsu = $idUsu;
			$this->idAutor = $idAutor;
			
			$opciones = array('action' => 'solicitud.php?idAni='. $this->idAni .'&idUsu='. $this->idUsu);
			
			parent::__construct("1", $opciones);
		}

		protected function generaCamposFormulario($datos, $errores = array())
	    {
			if (!estaLogado()) {
				$html = "<h2> Para comentar a este hilo debes de iniciar sesión </h2>";
				return $html;
			}
			$idUsuario = idUsuarioLogado();
			$nombreUsuario = nombreLogado();
			$apellidoUsuario = apellidoLogado();
			$srcIMG=srcUsuarioIMG($this->idUsu);
	    	$html = <<<EOS
			<fieldset>
				<div>
				<div class="row">
					<div class="cabeceraHiloIMG"> <a href = "perfil_user.php?id=$idUsuario"> <img class='perfilForo' src=$srcIMG /> </a> </div>
					<div class="cabeceraHilo" ><p><a href = "perfil_user.php?id=$idUsuario"> $nombreUsuario $apellidoUsuario </a> dice:  </p> </div>
				</div>
				<div class="comentario">
					<textarea class="comentarioHilo" type="text" name="comentario" required> </textarea>
				</div>	
				<button type="submit">Comentar</button>
				</div>
			</fieldset>
EOS;
	    	return $html;
	  	}

		protected function procesaFormulario($datos)
		{
			$errores = array();
			$comentario =  $datos['comentario'] ?? null;
			if (!strlen(trim($_POST['comentario'])))$errores[] = "¡Debes de comentar algo!";
			if (empty($comentario)) $errores[] = "¡Debes de comentar algo!";
			
			if(count($errores)===0){
				$entrada = EntradaContrato::nuevaEntradaContrato($this->idUsu,$this->idAni,$this->idAutor,$comentario,date("Y-m-d H:i:s"));
				if(!$entrada) $errores[]="ERROR AL INSERTAR COMENTARIO";
				else $errores = 'solicitud.php?idAni='. $this->idAni .'&idUsu='. $this->idUsu;
			}
			
			return $errores;
			
		}
	}

?>