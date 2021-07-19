<?php

namespace es\ucm\fdi\aw;

class FormularioRecaudar extends Form
{
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
	    	$html = <<<EOS
					<fieldset>
					<legend>Vamoh a cobrar</legend>			
					  <div>
						<input type="submit" name="recaudar" value="Recaudar" />
					  </div>
					</fieldset>
EOS;
			return $html;
    }
    

    protected function procesaFormulario($datos) {
		
		$apadrinados = Apadrinado::getApadrinados();
		
		foreach($apadrinados as $apadrinamiento){ 
			Transaccion::register($apadrinamiento->getID_usuario(), $apadrinamiento->getCantidad(), $apadrinamiento->getNumTarjeta(), $apadrinamiento->getID());
		}
		
		$result = 'controlPanel.php';
			
		return $result;
	}
}