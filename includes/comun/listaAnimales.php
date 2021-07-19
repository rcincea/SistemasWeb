<?php
	
	function listaAnimales($animales){
		$html = "";
		if($animales == false){
			$html = '<p> No hay animales disponibles </p>';
			return $html;
		}
		$cantidad = count($animales);
		
		$html.= '<div class="row">';
		for($i = 0; $i < $cantidad; $i+=2){
			/*
			$html.= '<div class="column">';
			$html .= '<h3 id="'.$animales[$i].'"><a href = "perfil_animal.php?id='.$animales[$i].'">'.$animales[$i+1].'</a></h3>';
			if(file_exists(RUTA_IMGANI.'/'.$animales[$i].'.jpg')){
				$html .= '<a href = "perfil_animal.php?id='.$animales[$i].'"><img src="img/ani/'.$animales[$i].'.jpg" alt="Foto animal'.$animales[$i].'"/></a>';
			}else{
				$html .= '<a href = "perfil_animal.php?id='.$animales[$i].'"><img src="img/ani/null.jpg" alt="Foto animal'.$animales[$i].'"/></a>';
			}
			$html.= '</div>';
			*/
			$idAnimal = $animales[$i];
			$nombreAnimal = $animales[$i+1];
			if(file_exists(FICHERO_IMGANI.'/'.$animales[$i].'.jpg')) $dirIMG = RUTA_IMGANI.'/'.$animales[$i].'.jpg';
			else $dirIMG = RUTA_IMGANI.'/null.jpg';
			$html .= <<<EOS
				<div class="column">
				<a href = "perfil_animal.php?id=$idAnimal"> 
					<div class="polaroid">
						<img class="contenedor" src="$dirIMG" alt="$nombreAnimal"/>
						<div class="container">
							<p>$nombreAnimal</p>
						</div>
					</div>
				</a>
				</div>			
EOS;
		}
		$html.= '</div>';
		
		return $html;
	}
	
	function listaAnimalesMuestra($animales,$muestra){
		$html = '';
		if($animales == false){
			$html = '<p> No hay animales disponibles </p>';
			return $html;
		}
		
		if(count($animales) < $muestra * 2) $cantidad = count($animales);
		else $cantidad = $muestra * 2;
		
		$html.= '<div class="row">';
		for($i = 0; $i < $cantidad; $i+=2){ 
			/*
			$html.= '<div class="column">';
			$html.= '<h3 id="'.$animales[$i].'"><a href = "perfil_animal.php?id='.$animales[$i].'">'.$animales[$i+1].'</a></h3>';
			if(file_exists(RUTA_IMGANI.'/'.$animales[$i].'.jpg')){
				$html.= '<a href = "perfil_animal.php?id='.$animales[$i].'"><img src="img/ani/'.$animales[$i].'.jpg" alt="Foto animal'.$animales[$i].'"/></a>';
			}else{
				$html.= '<a href = "perfil_animal.php?id='.$animales[$i].'"><img src="img/ani/null.jpg" alt="Foto animal'.$animales[$i].'"/></a>';
			}
			$html.= '</div>';
			*/
			$idAnimal = $animales[$i];
			$nombreAnimal = $animales[$i+1];
			if(file_exists(FICHERO_IMGANI.'/'.$animales[$i].'.jpg')) $dirIMG = RUTA_IMGANI.'/'.$animales[$i].'.jpg';
			else $dirIMG = RUTA_IMGANI.'/null.jpg';
			$html .= <<<EOS
				<div class="column">
				<a href = "perfil_animal.php?id=$idAnimal"> 
					<div class="polaroid">
						<img class="contenedor" src="$dirIMG" alt="$nombreAnimal"/>
						<div class="container">
							<p>$nombreAnimal</p>
						</div>
					</div>
				</a>
				</div>			
EOS;
		}
		$html.= '</div>';
		return $html;
	}
	
	
?>
