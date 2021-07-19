<?php

namespace es\ucm\fdi\aw;

class FormularioAscension extends Form
{
    
	private $idUsu;
	
	public function __construct($idUsu) {
		$this->idUsu = $idUsu;
		
		$opciones = array('action' => 'perfil_user.php?id='. $this->idUsu);
		
        parent::__construct("1", $opciones);
    }
	
    protected function generaCamposFormulario($datos, $errores = array())
    {
	    	$html = <<<EOS
					<fieldset>
					<legend>Cambiar tipo de usuario</legend>
						
						<div><label>tipo:</label> 
							<select name="type">
							  <option value="normal" selected>Normal</option>
							  <option value="veterinario">Veterinario</option>
							  <option value="voluntario">Voluntario</option>
							  <option value="administrador">Administrador</option>
							</select>
						</div>
						
					  <div>
						<input type="submit" name="cambiar" value="Cambiar" />
					  </div>
					</fieldset>
EOS;
			return $html;
    }
    

    protected function procesaFormulario($datos) {
		
		$type = $datos['type'];
		
		$user = Usuario::buscaPorID_usuario($this->idUsu);
		
		Usuario::editaTipo($user, $type);
			
		$result[] = 'Tipo actualizado';
		
		return $result;
	}
}