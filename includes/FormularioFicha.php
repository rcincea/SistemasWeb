<?php

namespace es\ucm\fdi\aw;


class FormularioFicha extends Form
{
    public function __construct() {
        parent::__construct('formFicha');
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $id = $_GET['id'];
        $html = <<<EOF
            <fieldset>
                    <label>id:</label> <input class="control" type="text" name="id" value="$id" readonly/>
                    <label>Vacunas:</label> <input class="control" type="text" name="vacunas" value=""/>
                    <label>Observaciones:</label> <input class="control" type="text" name="observaciones" value="" required/>
                <div class="grupo-control"><button type="submit" name="actualizar">Actualizar</button></div>
            </fieldset>
EOF;
        return $html;
    }
    

    protected function procesaFormulario($datos)
    {
        $result = array();
	
        $id = $datos['id'] ?? null;
        
        $vacunas = $datos['vacunas'] ?? null;
      
        $observaciones = $datos['observaciones'] ?? null;
       
	
	
        if (count($result) === 0) {
            $animal = Ficha::add($id, $vacunas,$observaciones);
            $animal->crear();
            if ( ! $animal ) {
                $result[] = "La ficha ya existe";
            } else {
                $result = "fichaVista.php?id=".$id;
            }
        }
        return $result;
    }
}
