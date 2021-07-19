<?php

namespace es\ucm\fdi\aw;

class FormularioDona extends Form
{
	
	private $idUsu;
	
    public function __construct($idUsu) {
		
		$this->idUsu = $idUsu;
		
        parent::__construct("1");
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
		$tarjeta = Tarjeta::buscaPorID_usuario($this->idUsu);
		
		if($tarjeta){
			$numero_tarjeta = $tarjeta->getNumTarjeta();
			$fecha_exp = $tarjeta->getCaducidad();
		}
		else{
			$numero_tarjeta = "";
			$fecha_exp = "";
		}
		
		$cvv = "";
		$cantidad = "";
		
        $html = <<<EOF
			<fieldset>
				<legend>Si te es posible, una donacion ayudaria mucho a nuestra causa</legend>
				<input class="control" type="text" maxlength="16" placeholder="1234 1234 1234 1234" name="numero_tarjeta" value="$numero_tarjeta">
				<div class="valid text">
				FECHA EXPIRACION
				</div>
				<div class="valid_date text">
				<input class="control" type="text" maxlength="5" size=4 placeholder="7/10" name="fecha_exp" value="$fecha_exp">
				</div>
				<div class="cvv text">
				CVV
				</div>
				<div class="cvv_numero text">
				<input class="control" type="text" maxlength="3" size=4 placeholder="000" name="cvv" value="$cvv">
				</div>
				<div class="cantidad text">
				CANTIDAD:
				<input class="control" type="text" maxlength="3" size=4 placeholder="30€" name="cantidad" value="$cantidad">
				</div>
				<div class="boton button"><button type="submit" name="registro">Donar</button></div>
			</fieldset>
EOF;
        return $html;
    }
    
    protected function procesaFormulario($datos)
    {
        $result = array();
		
		//Si no estan definidos salta warning
		
        $numero_tarjeta = $datos['numero_tarjeta'] ?? null;
		if ( empty($numero_tarjeta) || !is_numeric($numero_tarjeta)) {
            $result['numero_tarjeta'] = "El número de tarjeta tiene que tener una longitud de 16 números (sin espacios).";
        }
		
		$fecha_exp = $datos['fecha_exp'] ?? null;
		$word = "/";
		if(empty($fecha_exp) || strpos($fecha_exp , $word) == false){
			$result['fecha_exp'] = "Error al introducir la fecha de expiración, vuelve a intentarlo";
		}
		
		$cvv = $datos['cvv'] ?? null;
		if ( empty($cvv) || !is_numeric($cvv) ) {
            $result['cvv'] = "Solo puedes introducir números en el campo CVV.";
        }
		
		$cantidad = $datos['cantidad'] ?? null;
		if ( empty($cantidad) || !is_numeric($cantidad)) {
            $result['cantidad'] = "Solo puedes introducir números en el campo Cantidad (sin el caracter €).";
        }
        
        if (count($result) === 0) { 
			
            $tarjeta = Tarjeta::register($this->idUsu, $numero_tarjeta, $fecha_exp, $cvv);
			
            if ( ! $tarjeta ) {
                $result[] = "Hubo un error al insertar en la base de datos de Tarjeta, lo sentimos";
            }
			else{
				$transaccion = Transaccion::register($this->idUsu, $cantidad, $numero_tarjeta, NULL);
				
				if ( ! $transaccion ) {
					$result[] = "Hubo un error al insertar en la base de datos de Transaccion, lo sentimos";
				}
				else {
					$result[] = "Transferencia realizada con exito, muchas gracias por su colaboracion!";
				}
			}
        }
        return $result;
    }
}
