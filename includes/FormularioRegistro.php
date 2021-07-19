<?php
namespace es\ucm\fdi\aw;

class FormularioRegistro extends Form
{
    public function __construct() {
        parent::__construct('formRegistro');
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $DNI = $datos['DNI'] ?? '';
		$nombre = $datos['nombre'] ?? '';
		$apellido = $datos['apellido'] ?? '';
		$telefono = $datos['telefono'] ?? '';
		$email = $datos['email'] ?? '';
		$nacimiento = $datos['nacimiento'] ?? '';
		$direccion = $datos['direccion'] ?? '';
		
        $html = <<<EOF
            <fieldset>
					<head>
					  <meta charset="UTF-8" />
					  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
					  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
					</head>

					<body>
					  <div class="form">
						<h2>Registro</h2>
						<div class="input">
						  <div class="inputBox">
							<label>DNI</label>
							<input class"control" type="text" name="DNI" value="$DNI" placeholder="00000000A">
						  </div>
						  <div class="inputBox">
							<label>Nombre</label>
							<input class"control" type="text" name="nombre" value="$nombre" placeholder="Juan">
						  </div>
						  <div class="inputBox">
							<label>Apellido</label>
							<input class"control" type="text" name="apellido" value="$apellido" placeholder="Perez">
						  </div>
						  <div class="inputBox">
							<label>Teléfono</label>
							<input class"control" type="number" name="telefono" value="$telefono" placeholder="614876453">
						  </div>
						  <div class="inputBox">
							<label>E-mail</label>
							<input class"control" type="email" name="email" value="$email" placeholder="jperez@gmail.com">
						  </div>
						  <div class="inputBox">
							<label>Contraseña</label>
							<input class"control" type="password" name="contraseña" placeholder="********">
						  </div>
						  <div class="inputBox">
							<label>Vueleve a introducir la contraseña</label>
							<input class"control" type="password" name="contraseña2" placeholder="********">
						  </div>
						  <div class="inputBox">
							<label>Fecha de nacimiento</label>
							<input class"control" type="date" name="nacimiento" value="$nacimiento" placeholder="">
						  </div>
						  <div class="inputBox">
							<label>Dirección</label>
							<input class"control" type="text" name="direccion" value="$direccion" placeholder="Calle Mayor N7">
						  </div>
						  <div class="inputBox">
							<input type="submit" name="" value="Registrarse">
						  </div>
						</div>
					  </div>
					</body>
            </fieldset>
EOF;
        return $html;
    }
    

    protected function procesaFormulario($datos)
    {
        $result = array();
        $DNI = $datos['DNI'] ?? null;
		$letra = substr($DNI, -1);
		$numeros = substr($DNI, 0, -1);
		
		if (empty($DNI) || substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra || strlen($letra) != 1 || strlen ($numeros) != 8 ){
			$result['DNI'] = "El DNI tiene que tener 8 números y una letra al final.";
		}
        
        $nombre = $datos['nombre'] ?? null;
        if ( empty($nombre) || mb_strlen($nombre) < 2 ) {
            $result['nombre'] = "El nombre tiene que tener una longitud de al menos 2 caracteres.";
        }
		
		$apellido = $datos['apellido'] ?? null;
        if ( empty($apellido) || mb_strlen($apellido) < 2 ) {
            $result['apellido'] = "El apellido tiene que tener una longitud de al menos 2 caracteres.";
        }
		
		$telefono = $datos['telefono'] ?? null;
        if ( empty($telefono) || mb_strlen($telefono) != 9 ) {
            $result['telefono'] = "El teléfono tiene que tener una longitud de 9 números.";
        }
		
		// El e-mail ya viene filtrado por type="email"
		$email = $datos['email'] ?? null;
		
		$contraseña = $datos['contraseña'] ?? null;
        if ( empty($contraseña) || mb_strlen($contraseña) < 5 ) {
            $result['contraseña'] = "La contraseña tiene que tener una longitud de al menos 5 caracteres.";
        }
        $contraseña2 = $datos['contraseña2'] ?? null;
        if ( empty($contraseña2) || strcmp($contraseña, $contraseña2) !== 0 ) {
            $result['contraseña2'] = "Las contraseñas deben coincidir";
        }
		
		// La fecha de naciemiento ya viene filtrada por type="date"
		$nacimiento = $datos['nacimiento'] ?? null;
		
		$direccion = $datos['direccion'] ?? null;
        if ( empty($direccion) || mb_strlen($direccion) < 5 ) {
            $result['direccion'] = "La direccion tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        if (count($result) === 0) {
            $user = Usuario::register($DNI, $nombre, $apellido, $telefono, $email, $contraseña, $nacimiento, $direccion, date('Y-m-d'));
            if ( ! $user ) {
                $result[] = "El usuario ya existe";
            } else {
                $result = 'login.php';
            }
        }
        return $result;
    }
}
