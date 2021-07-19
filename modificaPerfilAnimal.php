<?php

require_once __DIR__.'/includes/config.php';

if (isset($_GET['id'])){
$form = new es\ucm\fdi\aw\FormularioEditarAnimal($_GET['id']);
$htmlFormRegistro = $form->gestiona();
}else $htmlFormRegistro = "<h1> No existe este animal </h1>";

$tituloPagina = 'Actualizar Animal';

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Editar Animal</h1>
$htmlFormRegistro
EOS;

require_once __DIR__.'/includes/plantillas/plantilla.php';
