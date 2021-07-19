<?php

require_once __DIR__.'/includes/config.php';
require_once ("includes/usuarioUtils.php");

$idAni = $_GET['id'];

$animal = es\ucm\fdi\aw\Animal::buscaPorID($idAni);
$nombre = $animal->getNombre();

$form = new es\ucm\fdi\aw\FormularioApadrina(idUsuarioLogado(), $idAni);
$htmlFormApadrina = $form->gestiona();

$tituloPagina = 'Apadrina';

$contenidoPrincipal = <<<EOS
        <h2>
	<span>&nbsp&nbsp</span>
	<span>&nbsp&nbsp</span>
	<span>&nbsp&nbsp</span>
	<span>&nbsp&nbsp</span>
	<span>&nbsp&nbsp</span>
	<span>&nbsp&nbsp</span>
            <span>A</span>
            <span>P</span>
            <span>A</span>
            <span>D</span>
            <span>R</span>
            <span>I</span>
            <span>N</span>
            <span>A</span>
	<span>&nbsp&nbsp</span>
            <span>A</span>
            <span>&nbsp&nbsp</span
            <span>$nombre</span>
        </h2>
	$htmlFormApadrina
EOS;

require __DIR__.'/includes/plantillas/plantillaApadrina.php';

