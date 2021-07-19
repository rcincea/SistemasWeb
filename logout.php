<?php
require_once __DIR__.'/includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['tipo']);
unset($_SESSION['DNI']);
unset($_SESSION['nombre']);


session_destroy();

$tituloPagina = 'Logout';

$contenidoPrincipal = <<<EOS
    <div class="loader">
        <h1>ADIÓS!</h1>
    </div>
EOS;

require __DIR__.'/includes/plantillas/plantillaLogout.php';
