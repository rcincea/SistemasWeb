<?php  
	namespace es\ucm\fdi\aw;

	class FormularioLogin extends Form {

		protected function generaCamposFormulario($datos, $errores = array())
	    {			
	    	$html = <<<EOS
					<fieldset>
						<head>
						  <meta charset="UTF-8" />
						  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
						  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
						</head>

						<body>
						  <div class="form">
							<h2>Login</h2>
							<div class="input">
							  <div class="inputBox">
								<label>DNI</label>
								<input class="control" type="text" name="DNI" placeholder="00000000A">
							  </div>
							  <div class="inputBox">
								<label>Contraseña</label>
								<input type="password" name="contraseña" placeholder="******">
							  </div>
							  <div class="inputBox">
								<input type="submit" name="login" value="Entrar">
							  </div>
							</div>
						  </div>
						</body>
					</fieldset>
EOS;
	    	return $html;
	  	}

	  	protected function procesaFormulario($datos)
	    {
	    	$errores = array();
	    	$DNI = isset($_POST['DNI']) ? $_POST['DNI'] : null;

			if ( empty($DNI) ) {
				$errores[] = "El DNI no puede estar vacío";
			}

			$pass = isset($_POST['contraseña']) ? $_POST['contraseña'] : null;
			if ( empty($pass) ) {
				$errores[] = "La contraseña no puede estar vacía.";
			}

			if (count($errores) === 0) {
				$usuario = Usuario::login($DNI,$pass);
				if($usuario){
					$_SESSION['login'] = true;
					$_SESSION['DNI'] = $DNI;
					$_SESSION['tipo'] = $usuario->getTipo();
					$_SESSION['nombre'] = $usuario->getNombre();
					$_SESSION['apellido'] = $usuario->getApellido();
					$_SESSION['id'] = $usuario->getID();
					$errores = 'index.php';
				}
				else{ 
					$errores[]="DNI o contraseña no validos";
				}
				
			}
				
	        return $errores;
	    }
	}
?>
