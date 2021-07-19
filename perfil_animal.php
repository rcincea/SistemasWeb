<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/usuarioUtils.php';


$tituloPagina = 'Perfil Animal';
$contenidoPrincipal = '<link rel="stylesheet" type="text/css" href="perfil.css" />';
$idSes = $_GET['id'];
$contenidoPrincipal.= "<div id='perfilanimalcontenedor'>";
$animal = es\ucm\fdi\aw\Animal::buscaPorID($idSes);
if ($animal == null) $contenidoPrincipal .= "<h2> No se ha encontrado con ningún animal  </h2>";
else {
    $tituloPagina = $animal->getNombre();
    $protectora = es\ucm\fdi\aw\Protectora::buscaProtectoraPorId($animal->getProtectora());
    //echo '<img src="data:imagenes;base64,' . base64_encode($animal->getImagen()) . ' "width=15%";>';
   
	if(file_exists(FICHERO_IMGANI.'/'.$animal->getID().'.jpg')){
        $contenidoPrincipal .= "<div id='contenedorImagen'>";
		$contenidoPrincipal .= "<img class='perfilAnimal' src=img/ani/".$animal->getID().".jpg alt=Foto animal".$animal->getID()."/>";
		if(permisosVoluntario()){
            $contenidoPrincipal .= "<div id='cambiarFotoContenedor'>";
			$contenidoPrincipal .="<p>Cambiar foto:</p>";
			$form = new es\ucm\fdi\aw\FormularioFotoAni($animal->getID());
			$contenidoPrincipal .= $form->gestiona();
            $contenidoPrincipal .= "</div>";
		}
	}else{
		$contenidoPrincipal .= "<img class='perfilAnimal' src=img/ani/null.jpg alt=Foto animal".$animal->getID()."/>";
		if(permisosVoluntario()){
            $contenidoPrincipal .= "<div id='cambiarFotoContenedor'>";
			$contenidoPrincipal .="<p>Añadir foto:</p>";
			$form = new es\ucm\fdi\aw\FormularioFotoAni($animal->getID());
			$contenidoPrincipal .= $form->gestiona();
            $contenidoPrincipal .= "</div>";
		}
	}
    $contenidoPrincipal .= "</div>";
    $contenidoPrincipal .= "<div id='perfilAnimalDerecha'>";
        $contenidoPrincipal .= "<div id='cabeceraDatos'>";
            $contenidoPrincipal .= "<div id='contenedorNameAnimal'>";
                 $contenidoPrincipal .=  "<p> " . $animal->getNombre() . "</p>";
            $contenidoPrincipal .= "</div>";
        if ($animal->getUrgente() && $animal->getId_propietario() == null) {
            $contenidoPrincipal .= "<div id='separado'>";
            $contenidoPrincipal .= "<p>¡URGENTE!</p>";
            $contenidoPrincipal .= "</div>";
        }
   
         $contenidoPrincipal .= "</div>";
    $contenidoPrincipal .= "<div id='contenedorDatosAnimal'>";
        if($animal->getTipo() != null){
            $contenidoPrincipal .=  "<p> " . $animal->getTipo() . " </p>";
        }
        if($animal->getRaza()  != null){
            $contenidoPrincipal .=    "<p> RAZA: " . $animal->getRaza() . " </p>";
        }
        if($animal->getSexo()!= null){
            $contenidoPrincipal .=    "<p> SEXO: " . $animal->getSexo() . " </p>";
        }
        if($animal->getPeso() != null){
            $contenidoPrincipal .=    "<p> PESO: " . $animal->getPeso() . " kg </p>";
        }
        if( $animal->getNacimiento() != null){
            $contenidoPrincipal .=    "<p> FECHA NACIMIENTO: " . $animal->getNacimiento() . " </p>";
        }
        if($animal->getFecha_ingreso() != null){
            $contenidoPrincipal .=    "<p> FECHA INGRESO: " . $animal->getFecha_ingreso() . " </p>";
        }
       
        if ($protectora == null) $contenidoPrincipal .=    "<p> PROTECTORA: Este animal no se encuentra en ninguna protectora o ha habido un error, contacte con un voluntario para más información </p>";
        else $contenidoPrincipal .=    '<a href = "protectora.php?id=' . $protectora->getID() . '">' . $protectora->getNombre() . '</a>';
        if ($animal->getId_propietario() != null) {
            $usuario = es\ucm\fdi\aw\Usuario::buscaPorID_usuario($animal->getId_propietario());
            $contenidoPrincipal .= "<p> Historia feliz: " . $animal->getHistoria_feliz() . "</p>";
            $contenidoPrincipal .= "<p> Adoptado por  " . $usuario->getNombre() . "</p>";
  
        }
    $contenidoPrincipal .="</div>";
    $contenidoPrincipal .="</div>";
    $contenidoPrincipal .="</div>";
    $contenidoPrincipal .= "<div id='botonesContenedor'>";
    if ($animal->getId_propietario() != null) {
      
               
       
            $contenidoPrincipal .= "<button type='button' class='boton' disabled>Adoptar</button>";
            $contenidoPrincipal .= "<button type='button'  class='boton'botondisabled>Apadrinar</button>";

        $contenidoPrincipal .= "<p> El animal está adoptado</p>";
    } else {
        if (estaLogado() && $animal->getId_propietario() == null) {

            $contenidoPrincipal .= <<<EOS
           
        <form action="adoption.php">
    	<input type="hidden" name="id" value="{$idSes}" />
	<input type="submit" class='boton' value="Adoptar" />
	</form>
	<form action="apadrina.php">
	<input type="hidden" name="id" value="{$idSes}" />
	<input type="submit" class='boton' value="Apadrinar" />
	</form>
   
EOS;
            if (permisosVeterinario()) {
                $contenidoPrincipal .= " <a class='boton' href=fichaVista.php?id={$idSes}> Ficha Medica</a>";
            }
            if (permisosVeterinario()) { // modificar
                $contenidoPrincipal .= <<<EOS
                <a class='boton' href=modificaPerfilAnimal.php?id={$idSes}> Editar perfil</a>
            </div>

        </div>
EOS;
            }
        } else {
            $contenidoPrincipal .= <<<EOS
            <button type="button" class="boton" disabled>Adoptar</button>
            <button type="button" class="boton">Apadrinar</button>
            <p> No estas logueado</p>
            </div>
        </div>
EOS;
        }
    }
}
require __DIR__ . '/includes/plantillas/plantilla.php';
