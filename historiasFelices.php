<?php

require_once __DIR__.'/includes/config.php';
require_once("includes/comun/listaAnimales.php");

$tituloPagina = 'Historias';
$adoptados = listaAnimales(es\ucm\fdi\aw\Animal::getAnimalesAdoptados());

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Nuestros animales adoptados</h1>
$adoptados
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';
