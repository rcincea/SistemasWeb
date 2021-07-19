<?php
require_once __DIR__.'/includes/config.php';
require_once ("includes/usuarioUtils.php");

$idAni = $_GET['id'];

$form = new es\ucm\fdi\aw\FormularioAdopcion($idAni,idUsuarioLogado());
$htmlFormAdopt = $form->gestiona();

$tituloPagina = 'Adoption';

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Inicio proceso adopcion</h1>
$htmlFormAdopt
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';
