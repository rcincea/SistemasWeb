<?php

namespace es\ucm\fdi\aw;

class FormularioApadrina extends Form
{
    private $idUsu;
    private $idAni;
	
    public function __construct($idUsu,$idAni) {
		
		$this->idUsu = $idUsu;
		$this->idAni = $idAni;
		
		$opciones = array('action' => 'apadrina.php?id='. $this->idAni);
		
        parent::__construct("1", $opciones);
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
			</fieldset>
				<head>
					<meta charset="UTF-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Ghost Text Animation</title>
					<link rel="shortcut icon" href="../../favicon.ico">
					<link rel="stylesheet" type="text/css" href="style.css" />
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title> Unipet </title>
				</head>
			
				<body class="active">
					<div class="floating">
					<div class="thickness"></div>
					<div class="thickness"></div>
					<div class="thickness"></div> 
					<div class="card_body">
					<div class="paypal_center svg"></div>
					<div class="logo svg"></div>
					<div class="paywave svg"></div>
					<div class="chips svg"></div>
					<div class="card_no text">
					<input class="control" type="tel" maxlength="16" placeholder="1234 1234 1234 1234" name="numero_tarjeta" value="$numero_tarjeta">
					</div>
					<div class="valid text">
					FECHA <br> EXP
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
					CANTIDAD MENSUAL:
					<input class="control" type="text" maxlength="3" size=4 placeholder="30€" name="cantidad" value="$cantidad">
					</div>
					<div class="mastercard_icon svg"></div>
					</div>
					</div>
					<div class="boton button"><button type="submit" name="registro">Apadrinar</button></div>
				</body>
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
				
				$userAnimal = Apadrinado::register($this->idUsu, $this->idAni, $cantidad, $numero_tarjeta);
				
				if ( ! $userAnimal ) {
					$result[] = "No se ha podido registrar su apadrinamiento.";
				}
				else{
					 $result = 'index.php';
				}
				
			}
			
        }
        return $result;
    }
}
