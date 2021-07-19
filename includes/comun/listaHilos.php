<?php

	function listaHilosMuestra($hilos, $muestra){
		$html = '';
		if($hilos == false){
			$html.= '<p>No hay ningún hilo actualmente</p>';
		}
		else{
			if(count($hilos)<= $muestra)
				$cantidad = count($hilos);
			else
				$cantidad = $muestra;
			
			$html.= '<hr />';
			for($i = 0; $i < $cantidad; $i++){ 
				$html.= '<h3>- <a href = "hiloForo.php?hilo='.$hilos[$i]->getID().'">'.$hilos[$i]->getTitulo().'</a></h3>';
				$html.= '<p>'.$hilos[$i]->getComentario().'</p>';
				$html.= '<hr />';
			}
		}
		return $html;
	}
	
		function listaHilos($hilos){
		$html = '';
		if($hilos == false){
			$html.= '<p>No hay ningún hilo actualmente</p>';
		}
		else{
			
			$cantidad = count($hilos);
			
			for($i = 0; $i < $cantidad; $i++){ 
				$html .= '<div class="hilo">';
				$html.= '<h2 class="tituloHilo "> <a href = "hiloForo.php?hilo='.$hilos[$i]->getID().'">'.$hilos[$i]->getTitulo().'</a></h2>';
				$html.= '<p class="hilo">'.$hilos[$i]->getComentario().'</p>';
				$html .= '</div>';
				$html.= '<hr class="barraForo"/>';
			}
		}
		return $html;
	}


?>