<?php
	function listaSolicitudes($solicitudes){
		if ($solicitudes == null) {
			$html = "<p> No se han encontrado solicitudes </p>";
			return $html;
		}
		$cantidad = count($solicitudes);
		$html = '';
		 foreach($solicitudes as $i){ 
			$html .= '<h3><a href = "solicitud.php?idAni='.$i->getID().'&idUsu='.$i->getID_usuario().'">'.$i->getNombreAnimal().' - '.$i->getNombreUsuario().' ('.$i -> getEstado().')</a></h3>';
		  }
		 return $html;
	}
	?>
