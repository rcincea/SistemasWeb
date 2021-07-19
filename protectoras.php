<?php

require_once __DIR__.'/includes/config.php';
require_once ("includes/comun/listaProtectoras.php");

$tituloPagina = 'Protectoras';
$protectors = listaProtectoras(es\ucm\fdi\aw\Protectora::getProtectoras());

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Protectoras:</h1>
$protectors
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';
