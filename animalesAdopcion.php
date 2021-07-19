<?php

require_once __DIR__."/includes/config.php";
require_once 'includes/comun/listaAnimales.php';

$tituloPagina = 'Animales en Adopcion';
$formBuscaAnimales = new es\ucm\fdi\aw\FormularioBusquedaAnimales('1');
$form = $formBuscaAnimales->gestiona();

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Animales en adopción</h1>
$form
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';
