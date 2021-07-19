<?php
	
	namespace es\ucm\fdi\aw;
	require_once "usuarioUtils.php";
	
	class FormularioHilo extends Form {
		
		private $idUsu;
		
		public function __construct($idUsu) {
			
			$this->idUsu = $idUsu;
			
			$opciones = array('action' => 'foro.php');
			
			parent::__construct("1", $opciones);
		}

		protected function generaCamposFormulario($datos, $errores = array())
	    {
	    	$html = <<<EOS
			<fieldset>
				<label> Iniciar nuevo tema en el foro </label>
				<div><label> Titulo </label> <input type="text" maxlength="255" name="titulo" required /></div> 
				<div><label> Comentario </label> <textarea class="comentarioHilo" type="text" name="comentario" required> </textarea></div>
				<div><button type="submit">Publicar</button></div>
			</fieldset>
EOS;
	    	return $html;
	  	}

		protected function procesaFormulario($datos)
		{
			$errores = array();
			$comentario =  $datos['comentario'] ?? null;
			$titulo = $datos['titulo'] ?? null;
			if (!strlen(trim($_POST['comentario'])))$errores[] = "¡Debes de comentar algo!";
			if (empty($comentario)) $errores[] = "¡Debes de comentar algo!";
			if (empty($titulo)) $errores[] = "¡Debes de titularlo!";
			
			if(count($errores)===0){
				$hilo = Hilo::nuevoHilo($this->idUsu,$titulo,$comentario,date("Y-m-d H:i:s"));
				if(!$hilo) $errores[]="ERROR AL INSERTAR COMENTARIO";
				else $errores = 'hiloForo.php?hilo='.$hilo->getID();
			}
			
			return $errores;
			
		}
	}
?>
