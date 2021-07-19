<?php
	require_once ("includes/config.php");
	require_once ("includes/usuarioUtils.php");
?>

<div class = "bordePie">
	<div class = "interioPie">
		<div class="row">
			<footer>
				<div class="column">
					<div id='contenedorImagen'>
						<a href="index.php"><img class="logoPie" src="img/Logo.jpg" alt="Foto Logo"></a>
					</div>
				</div>
				<div class="column">
					<ul>
						<li> <a href="index.php" > Inicio </a></li>
						<li> <a href="animalesAdopcion.php" > Animales en adopción </a></li>
						<li> <a href="protectoras.php" > Protectoras </a></li>
						<li> <a href="historiasFelices.php" > Historias Felices </a></li>
						<li> <a href="colabora.php"> Colabora con nosotros </a></li>
						<li> <a href="foro.php" > Foro </a></li>
					</ul>
				</div>
				
				<?php
					if(estaLogado()){
						$form = new es\ucm\fdi\aw\FormularioInforma("1");
						$htmlFormInforma = $form->gestiona();
						
						$contenidoPrincipal = <<<EOS
						<div class="column">
							<div class="formColabora">
							$htmlFormInforma
							</div>
						</div>
EOS;
						echo $contenidoPrincipal;
					}
				?>
				
				<div class="ultColumn">
					<h1>Gracias por su colaboración</h1>
					<p>Unipet Corporation, Todos los derechos reservados</p>
				</div>
				
			</footer>
		</div>
	</div>
</div>
