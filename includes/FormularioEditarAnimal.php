<?php

namespace es\ucm\fdi\aw;
require_once "categorias.php";

class FormularioEditarAnimal extends Form
{
	private $idAni;
    public function __construct($idAni) {
		$this->idAni=$idAni;
       	$opciones = array('action' => 'modificaPerfilAnimal.php?id='. $this->idAni);
        parent::__construct("1", $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        
        $animal = Animal::buscaPorID($this->idAni);
		if (!$animal) {
			$html = "<h1> NO EXISTE EL ANIMAL CON ID = ".$this->idAni."</h1>";
			return $html;
		}
        $id =  $animal->getId() ?? '';
		$nombre =  $animal->getNombre() ?? '';
		$nacimiento =  $animal->getNacimiento() ?? '';
		$tipo =  $animal->getTipo() ?? '';
		$raza =  $animal->getRaza() ?? '';
		$sexo =  $animal->getSexo() ?? '';
		$peso =  $animal->getPeso() ?? '';
        $protectora =$animal->getProtectora() ?? '';
        $historia = $animal->getHistoria_feliz() ?? '';
        $urgente =  $animal->getUrgente() ?? '';
		$fechaIngreso = $animal->getFecha_ingreso() ?? '';

      	$opciones = "";
	for($i = 0; $i < NANIMALES; $i++){
		if ($animal->getTipo()==ANIMALES[$i]) $opciones .= "<option value=".ANIMALES[$i]." selected>".ANIMALES[$i]."</option>";
		else $opciones .= "<option value=".ANIMALES[$i].">".ANIMALES[$i]."</option>";
	}
        $html = <<<EOF
            <fieldset>
                    <label>id:</label> <input class="control" type="number" name="id" value="$id" readonly/>
                    <label>Nombre:</label> <input class="control" type="text" name="nombre" value="$nombre"required/>
                    <label>Nacimiento:</label> <input class="control" type="date" name="nacimiento" value="$nacimiento" required/>
                    <label>tipo:</label> <select name="tipo">$opciones</select>
                    <label>raza:</label> <input class="control" type="text" name="raza" value="$raza" required/>
                    <label>sexo:</label> <input class="control" type="text" name="sexo" value="$sexo" required />
                    <label>peso:</label> <input class="control" type="number" step="0.1" name="peso" value="$peso" required/>
					<label>Ingreso:</label>	<input type="date" name="fechaIngreso" value="$fechaIngreso" required/>
                    <label>protectora:</label> <input class="control" type="number" name="protectora" value='$protectora' required/>
                    <label>historia:</label> <input class="control" type="text" name="historia" value="$historia"/>
                    <label>urgente:</label> <select name="urgente"> <option value="0">NO</option> <option value="1">SI</option></select>
                <div class="grupo-control"><button type="submit" name="actualizar">Actualizar</button></div>
            </fieldset>
EOF;
        return $html;
    }
    

    protected function procesaFormulario($datos)
    {
        $result = array();
	
        $id = $datos['id'] ?? null;
        
        $nombre = $datos['nombre'] ?? null;
        if ( empty($nombre) || mb_strlen($nombre) < 3 ) {
            $result['nombre'] = "El nombre tiene que tener una longitud de al menos 3 caracteres.";
        }
        $sexo = $datos['sexo'] ?? null;
        if ( empty($sexo) || mb_strlen($sexo) < 2 ) {
            $result['sexo'] = "El sexo tiene que tener una longitud de al menos 2 caracteres.";
        }
		$raza = $datos['raza'] ?? null;
		$peso = $datos['peso'] ?? null;
        $tipo = $datos['tipo'] ?? null;
        $historia = $datos['historia'] ?? null;

		$fechaIngreso = $datos['fechaIngreso'] ?? null;
		$protectora = $datos['protectora'] ?? null;
        $urgente = $datos['urgente'] ?? null;
		
		
		// La fecha de naciemiento ya viene filtrada por type="date"
		$nacimiento = $datos['nacimiento'] ?? null;
		
	
        if (count($result) === 0) {
            $animal = Animal::actualizar($id, $nombre, $nacimiento, $tipo, $raza, $sexo, $peso,$fechaIngreso ,$protectora, $historia, $urgente);
            if ( ! $animal ) {
                $result[] = "El animal no existe";
            } else {
                $result = "perfil_animal.php?id=".$id;
            }
        }
        return $result;
    }
}
