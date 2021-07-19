<?php
	function listaProtectoras($protectoras){
		$cantidad = count($protectoras);
		$html = "";
		if($protectoras == false){
			$html .= '<p>No hay protectoras</p>';
		}
		else{
			$html .= '<hr/>';
			for ($i = 0; $i < $cantidad; $i++) {
				$html .= '<h3>nombre: <a href = "protectora.php?id='.$protectoras[$i]->getID().'">'.$protectoras[$i]->getNombre().'</a></h3>';
				$html .= '<h3>direccion: '.$protectoras[$i]->getDireccion().'</h3>';
				$html .= '<h3>telefono: '.$protectoras[$i]->getTelefono().'</h3>';
				$html .= '<hr/>';
			}
		}
		return $html;
	}

	