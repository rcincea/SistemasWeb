<?php

require_once __DIR__.'/includes/config.php';
require_once("includes/comun/listaAnimales.php");
require_once("includes/comun/listaHilos.php");

$tituloPagina = 'Portada';

$muestraUrgentes = listaAnimalesMuestra(es\ucm\fdi\aw\Animal::getUrgentes(),5);
$muestraAcogPerros = listaAnimalesMuestra(es\ucm\fdi\aw\Animal::getUltimosAcogidos("perro"),5);
$muestraAcogGatos = listaAnimalesMuestra(es\ucm\fdi\aw\Animal::getUltimosAcogidos("gato"),5);
$muestraAdopcion = listaAnimalesMuestra(es\ucm\fdi\aw\Animal::getEnAdopcion(),5);
$muestraHilos = listaHilosMuestra(es\ucm\fdi\aw\Hilo::getHilos(), 5);

$contenidoPrincipal = <<<EOS
<h1 class="titulo">¡Adopciones Urgentes!</h1>
$muestraUrgentes
<h1 class="titulo">¿Como puedes ayudarnos?</h1>
<ol>		
	<li><p>Puedes trabajar con nosotros como voluntario (es vocacional y no está remunerado) para solicitar serlo ve al apartado colabora con nosotros que se encuentra en la cabecera o el pie de pagina</p></li>
	<li><p>Tambien puedes optar ayudando a uno de nuestro animales adoptandolo y aportandole un hogar propio</p></li>
	<li><p>Si no puedes adoptar, tambien tienes la opcion de apadrinarlo, con esto ayudas a que los animales vivan mejor</p></li>
	<li><p>La ultima opcion pero no por ello menos importante, puedes hacernos una donacion directa a nosotros, todo el dinero recaudado irá para el bienestar de nuestros animales</li>
</ol>
<p>Si te has quedado con alguna duda, tienes un apartado en la propia pagina web para publicarlas, cualquier usuario o incluso nuestro voluntarios y trabajadores te responderan con la mayor brevedad posible,</p>
<p>Muchas gracias por su colaboracion.</p>
<h1 class="titulo">Ultimos animales acogidos:</h1>
<h1>- Perros:</h2>
$muestraAcogPerros
<h1>- Gatos:</h2>
$muestraAcogGatos
<h1 class="titulo">Animales en adopcion:</h1>
$muestraAdopcion
<h1 class="titulo">Entradas al foro:</h1>
$muestraHilos
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';
