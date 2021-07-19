<?php

namespace es\ucm\fdi\aw;

class FormularioAddProt extends Form
{
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
			$nameProtectora = $datos['nameProtectora'] ?? null;
			$direccion = $datos['direccion'] ?? null;
			$telefono = $datos['telefono'] ?? null;
	    	$html = <<<EOS
					<fieldset>
						<legend>Rellene los datos de la protectora</legend>
						
						<div><label>Nombre:</label> 
							<input type="text" name="nameProtectora" value="$nameProtectora" size="25"/>
						</div>
						
						<div><label>Dirección:</label> 
							<input type="text" name="direccion" value="$direccion" size="50"/>
						</div>
						
						<div><label>Teléfono:</label> 
							<input type="number" name="telefono" value="$telefono" size="15"/>
						</div>
						
						<div><button type="submit">Añadir</button> <button type="reset">Borrar todo</button></div>
					</fieldset>
EOS;
			return $html;
    }
    

    protected function procesaFormulario($datos) {
		
		$result = array();
		$nameProtectora = $datos['nameProtectora'] ?? null;
		$direccion = $datos['direccion'] ?? null;
		$telefono = $datos['telefono'] ?? null;
		
		if (empty($nameProtectora) || empty($direccion) || empty($telefono) ){
			$result[] = 'No puede quedar un campo sin rellenar';
		}
		
		if (mb_strlen($telefono) != 9){
			$result[] = 'El telefono debe tener 9 digitos';
		}
		
		if (count($result) === 0) {
			$prot = Protectora::nuevaProtectora($nameProtectora, $direccion, $telefono);
			if($prot) $result = 'controlPanel.php';
            else $result[] = 'Algo ha fallado en la BD';
        }
		
		return $result;
	}
}
