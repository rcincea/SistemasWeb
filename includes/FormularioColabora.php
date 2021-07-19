<?php

namespace es\ucm\fdi\aw;
require_once ("includes/usuarioUtils.php");

class FormularioColabora extends Form
{
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
	    	$html = <<<EOS
					<fieldset>
					<legend>Si quiere presentarse como voluntario, dejenos a continuacion una solicitud diciendonos sus motivaciones para tal acto</legend>
					  <div>
						<label>Motivaciones</label> <input class ="control" type="text" name="voluntariado" size="200" required />
					  </div>
					  <div>
						<input type="submit" name="submit" value="Send" />
						<input type="reset" name="reset" value="Clear" />
					  </div>
					</fieldset>
EOS;
			return $html;
    }
    

    protected function procesaFormulario($datos) {
		
		$result = array();
		
        $voluntariado = $datos['voluntariado'] ?? null;
		
		if(mb_strlen($voluntariado) < 10){
			$result[] = 'Por favor, indiquenos con más extension cuales son sus motivaciones';
		}else{
			$comentario = Colabora::add(idUsuarioLogado(), $voluntariado);
			Colabora::inserta($comentario);
			$result = 'colabora.php';
		}
		
		
		return $result;
	}
}
