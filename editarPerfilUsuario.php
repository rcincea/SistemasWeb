<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioEditarUsuario("1");
$htmlFormRegistro = $form->gestiona();

$tituloPagina = 'Actualizar';

$contenidoPrincipal = <<<EOS
<h1 class="titulo">Editar Perfil</h1>
$htmlFormRegistro
EOS;

require_once __DIR__.'/includes/plantillas/plantilla.php';
