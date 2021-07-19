<?php

namespace es\ucm\fdi\aw;
require_once "categorias.php";

class FormularioAddAni extends Form
{
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
			$nameAnimal = $datos['nameAnimal'] ?? '';
			$fechaNacimiento = $datos['fechaNacimiento'] ?? '';
			$raza = $datos['raza'] ?? '';
			$sexo = $datos['sexo'] ?? '';
			$peso = $datos['peso'] ?? '';
			$fechaIngreso = $datos['fechaIngreso'] ?? '';
			$protectora = $datos['protectora'] ?? '';
			$protectorasOpt = "";
			$protectoras = Protectora::getProtectoras();
			if ($protectoras)foreach($protectoras as $i) $protectorasOpt .= "<option value=".$i->getID().">".$i->getNombre()."</option>";
	    			$opciones = "";
			for($i = 0; $i < NANIMALES; $i++){
				$opciones .= "<option value=".ANIMALES[$i].">".ANIMALES[$i]."</option>";
			}
	    	$html = <<<EOS
					<fieldset>
						<legend>Rellene los datos del animal</legend>
												
						<div><label>Nombre:</label> 
							<input type="text" name="nameAnimal" value="$nameAnimal" size="25"/>
						</div>
						
						<div><label>Nacimiento:</label> 
							<input type="date" name="fechaNacimiento" value="$fechaNacimiento" size="25"/>
						</div>
						
						<div><label>Tipo:</label> 
							<select name="type">
								$opciones
							</select>
						</div>
						
						<div><label>Raza:</label> 
							<input type="text" name="raza" value="$raza" size="25"/>
						</div>
						
						<div><label>Sexo:</label> 
							<select name="sexo">
							  <option value="macho" selected>Macho</option>
							  <option value="hembra">Hembra</option>
							</select>
						</div>
						
						<div><label>Peso:</label> 
							<input type="number" name="peso" step="0.1" value="$peso" size="20"/>
						</div>
						
						<div><label>Ingreso:</label> 
							<input type="date" name="fechaIngreso" value="$fechaIngreso" size="25"/>
						</div>
						
						<div><label>Protectora:</label> 
							<select name="protectora">
							$protectorasOpt
							</select>
						</div>
						
						<div><button type="submit">Añadir</button> <button type="reset">Borrar todo</button></div>
					</fieldset>
EOS;
			return $html;
    }
    

    protected function procesaFormulario($datos) {
		
		$result = array();
		$nameAnimal = $datos['nameAnimal'] ?? null;
		$fechaNacimiento = $datos['fechaNacimiento'] ?? null;
		$type = $datos['type'] ?? null;
		$raza = $datos['raza'] ?? null;
		$sexo = $datos['sexo'] ?? null;
		$peso = $datos['peso'] ?? null;
		$fechaIngreso = $datos['fechaIngreso'] ?? null;
		$protectora = $datos['protectora'] ?? null;
		
		if (empty($nameAnimal) || empty($fechaNacimiento) || empty($type) || empty($raza) || empty($sexo) || empty($peso) || empty($fechaIngreso) || empty($protectora)){
			$result[] = 'No puede quedar un campo sin rellenar';
		}
		
		if (count($result) === 0) {
			$ani = Animal::nuevoAnimal($nameAnimal, $fechaNacimiento, $type, $raza, $sexo, $peso, $fechaIngreso, $protectora);
			if ($ani) $result = 'controlPanel.php';
			else $result[]="Algo ha fallado en la BD";
            
        }
		
		return $result;
	}
}
