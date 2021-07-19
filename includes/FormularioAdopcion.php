<?php
	
	namespace es\ucm\fdi\aw;
	
	class FormularioAdopcion extends Form {

		private $idAni;
		private $idUsu;
		
		public function __construct($idAni, $idUsu)
		{
			$this->idAni = $idAni;
			$this->idUsu = $idUsu;
			
			$opciones = array('action' => 'adoption.php?id='. $this->idAni);
			
			parent::__construct("1", $opciones);
		}
		
		protected function generaCamposFormulario($datos, $errores = array())
	    {
			
	    	$html = <<<EOS
					<fieldset>
				<legend>Rellene las preguntas</legend>
				
				<div><label>¿Has tenido (o tienes) animales?</label> 
					<input type="radio" name="animalAnt" value="si" /> Si
					<input type="radio" name="animalAnt" value="no" checked/> No
				</div>
				
				<div><label>¿Quien se va a encargar de la mascota?</label> 
					<input type="text" name="seEncargaMascota" value="" size="50"/>
				</div>
				
				<div><label>¿En que tipo de domicilio vivirá diariamente?</label> 
					<select name="typeOfHouse">
					  <option value="apartamento" selected>Apartamento</option>
					  <option value="pisoGrande">Apartamento grande</option>
					  <option value="chalet">Chalet</option>
					  <option value="finca">Finca</option>
					  <option value="ninguno">Ninguno</option>
					</select>
				</div>
				
				<div><label>¿Viven niños en el mismo domicilio en el que se encontrará el animal?</label> 
					<input type="radio" name="niños" value="si" /> Si
					<input type="radio" name="niños" value="no" checked/> No
				</div>
				
				<div><label>¿Todos los que vivan en la casa están de acuerdo con la adopción?</label> 
					<input type="radio" name="deAcuerdo" value="si" /> Si
					<input type="radio" name="deAcuerdo" value="no" checked/> No
				</div>
				
				<div><label>¿Cuantas horas estaría solo el animal?</label> 
					<input type="text" name="horaSolo" value="" size="50"/>
				</div>
				
				<div><label>¿Cual es tu motivación por adoptar un animal?</label> 
					<input type="text" name="razonAdopcion" value="" size="200"/>
				</div>
				
				<div><button type="submit">Enviar</button> <button type="reset">Restablecer formulario</button></div>
			</fieldset>
EOS;
	    	return $html;
	  	}

	  	protected function procesaFormulario($datos)
	    {
	    	$errores = array();
			
	    	$animalAnt = isset($_POST['animalAnt']) ? $_POST['animalAnt'] : null;
			
			$seEncargaMascota = isset($_POST['seEncargaMascota']) ? $_POST['seEncargaMascota'] : null;

			$typeOfHouse = isset($_POST['typeOfHouse']) ? $_POST['typeOfHouse'] : null;
			
			$niños = isset($_POST['niños']) ? $_POST['niños'] : null;
			
			$deAcuerdo = isset($_POST['deAcuerdo']) ? $_POST['deAcuerdo'] : null;
			
			$horaSolo = isset($_POST['horaSolo']) ? $_POST['horaSolo'] : null;
			
			$razonAdopcion = isset($_POST['razonAdopcion']) ? $_POST['razonAdopcion'] : null;
			
			
			if ( empty($animalAnt) || empty($typeOfHouse) || empty($niños) || empty($horaSolo) || empty($razonAdopcion) ) {
				$errores[] = "Ningún campo puede quedar sin responder.";
			}
			else{
				
				$respuesta1 = $_POST['animalAnt'];
				$respuesta2 = $_POST['seEncargaMascota'];
				$respuesta3 = $_POST['typeOfHouse'];
				$respuesta4 = $_POST['niños'];
				$respuesta5 = $_POST['deAcuerdo'];
				$respuesta6 = $_POST['horaSolo'];
				$respuesta7 = $_POST['razonAdopcion'];

				$textoFormulario = sprintf("¿Has tenido (o tienes) animales? %s 
											¿Quien se va a encargar de la mascota? %s 
											¿En que tipo de domicilio vivirá diariamente? %s 
											¿Viven niños en el mismo domicilio en el que se encontrará el animal? %s 
											¿Todos los que vivan en la casa están de acuerdo con la adopción? %s 
											¿Cuantas horas estaría solo el animal? %s
											¿Cual es tu motivación por adoptar un animal? %s"
									  , $respuesta1
									  , $respuesta2
									  , $respuesta3
									  , $respuesta4
									  , $respuesta5
									  , $respuesta6
									  , $respuesta7);

				$contract = Contrato::buscaPorIDeID($this->idUsu,$this->idAni);
				
				if (!$contract) {
					$contract = Contrato::crea($this->idUsu, $this->idAni, $textoFormulario);
					$contract->guarda();
				} else {
					if($contract->ComprobarEnProceso()){
						$contract-> setFormulario($textoFormulario);
						$contract->guarda();
					}
				}
				
				$errores = 'index.php';
			}
				
	        return $errores;
	    }
	}
?>
