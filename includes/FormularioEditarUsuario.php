<?php

namespace es\ucm\fdi\aw;

require_once "usuarioUtils.php";


class FormularioEditarUsuario extends Form
{
    public function __construct() {
        parent::__construct('formEditUsuario');
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        
        $user = Usuario::buscaPorID_usuario( idUsuarioLogado());
        $DNI = $user->getDni() ?? '';
		$nombre = $user->getnombre() ?? '';
		$apellido = $user->getApellido() ?? '';
		$telefono = $user->getTelefono() ?? '';
		$email = $user->getEmail() ?? '';
        //$contraseña = $user->getContraseña();
		$nacimiento = $user->getNacimiento() ?? '';
		$direccion = $user->getDireccion() ?? '';

        $html = <<<EOF
            <fieldset>
                    <label>DNI:</label> <input class="control" type="text" name="DNI" value="$DNI" readonly/>
                    <label>Nombre:</label> <input class="control" type="text" name="nombre" value="$nombre"required/>
                    <label>Apellido:</label> <input class="control" type="text" name="apellido" value="$apellido" required/>
                    <label>Teléfono:</label> <input class="control" type="number" name="telefono" value="$telefono"required/>
                    <label>E-mail:</label> <input class="control" type="email" name="e-mail" value="$email"/>
                    <label>Contraseña:</label> <input class="control" type="password" name="contraseña" required/>
                    <label>Vuelve a introducir la contraseña:</label> <input class="control" type="password" name="contraseña2" required/>
                    <label>Fecha de Nacimiento:</label> <input class="control" type="date" name="nacimiento" value="$nacimiento"/>
                    <label>Dirección:</label> <input class="control" type="text" name="direccion" value="$direccion" required/>
                <div class="grupo-control"><button type="submit" name="actualizar">Actualizar</button></div>
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
		
		//$DNI = $datos['DNI'] ?? null;
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
		$email = $datos['e-mail'] ?? null;
		
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
            $user = Usuario::actualiza(idUsuarioLogado(),$DNI, $nombre, $apellido, $telefono, $email, $contraseña, $nacimiento, $direccion);
            if ( ! $user ) {
                $result[] = "El usuario ya existe";
            } else {
                $result = 'perfil_user.php';
            }
        }
        return $result;
    }
}
