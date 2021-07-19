<?php
	
	namespace es\ucm\fdi\aw;
	require_once "categorias.php";
	
	class FormularioCambio extends Form {

		private $idAni;
		private $idUsu;
		
		public function __construct($idAni, $idUsu)
		{
			$this->idAni = $idAni;
			$this->idUsu = $idUsu;
			
			$opciones = array('action' => 'solicitud.php?idAni='. $this->idAni .'&idUsu='. $this->idUsu);
			
			parent::__construct("1", $opciones);
		}
		
		protected function generaCamposFormulario($datos, $errores = array())
	    {
			$contract = Contrato::buscaPorIDeID($this->idUsu,$this->idAni);
			$opciones = "";
			
			for($i = 0; $i < NESTADOS; $i++){
				if ($contract->getEstado()==ESTADOS[$i]) $opciones .= "<option value=".ESTADOS[$i]." selected>".ESTADOS[$i]."</option>";
				else $opciones .= "<option value=".ESTADOS[$i].">".ESTADOS[$i]."</option>";
			}
			if ($contract->getEstado()==ESTADOS[4] || $contract->getEstado()==ESTADOS[5] ) {
				$html = "";	// El contrato ya ha entrado en su fase definitiva
				return $html;
			}		
			
	    	$html = <<<EOS
					<fieldset>
						<div><label>Estado: </label>
							<select name="estado">
							$opciones
							</select>
							<button type="submit">Enviar</button>
						</div>
					</fieldset>
EOS;
	    	return $html;
	  	}

	  	protected function procesaFormulario($datos)
	    {
			$errores = array();
			
	    	$contract = Contrato::buscaPorIDeID($this->idUsu,$this->idAni);
			
			if (!$contract) {
				$errores[] = "Error. No se ha encontrado el contrato.";
			}
			else{
				$contract->setEstado($datos['estado']);
				$contract->guarda();
				if($contract->getEstado()==ESTADOS[5] && Animal::adoptarAnimal($this->idAni,$this->idUsu)) {
					Contrato::rechazaContratos($this->idAni); // Ya rechaza los otros contratos que tenga el animal pendiente
					$contract->guarda();
				}
				$errores = 'solicitud.php?idAni='. $this->idAni .'&idUsu='. $this->idUsu;
			}
				
	        return $errores;
	    }
	}
	/*
								  <option value="EnTramite" selected>En tramite</option>
							  <option value="FaltDatos">Faltan datos</option>
							  <option value="PendCita">Pendiente de cita</option>
							  <option value="EsperaRes">Esperar respuesta</option>
							  <option value="Rechazado">Rechazar</option>
							  <option value="Aprobado">Aprobar</option>
	*/
?>