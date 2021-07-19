<?php
	function listaUsuarios($usuarios){
		if ($usuarios == null) {
			$html = "<p> No se han encontrado usuarios </p>";
			return $html;
		}
		$cantidad = count($usuarios);
		$html = '';
		 foreach($usuarios as $i){ 
			$html .= '<h3><a href = "perfil_user.php?id='.$i->getID().'&nombre='.$i->getNombre().'">'.$i->getNombre().' - '.$i->getEmail().' ('.$i -> getTipo().')</a></h3>';
		  }
		 return $html;
	}
	?>