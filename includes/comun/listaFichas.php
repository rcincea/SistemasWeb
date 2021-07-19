<?php
	function listaFichas($fichas){
		if ($fichas == null) {
			$html = "<p> No se han encontrado fichas </p>";
			return $html;
		}
		$html = '';
		 foreach($fichas as $i){ 
			$html .= '<h3><a href = "perfil_animal.php?id='.$i->getID().'">'.$i->getID().' - '.$i->getVacunas().' - '.$i->getObservaciones().'</a></h3>';
		  }
		 return $html;
	}
	?>
