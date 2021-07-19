<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioAddAni("1");
$htmlFormAddAni = $form->gestiona();

$tituloPagina = 'Add ani';

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Añadir animal</h1>
$htmlFormAddAni
EOS;

require_once __DIR__.'/includes/plantillas/plantilla.php';
