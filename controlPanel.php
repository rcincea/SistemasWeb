<?php

require_once __DIR__.'/includes/config.php';
require_once ("includes/usuarioUtils.php");

if(estaLogado() && permisosVoluntario()){
$solicitudes = es\ucm\fdi\aw\Contrato:: getSolicitudes();
$tablaSolicitudes= <<<EOS
<table>
  <tr>
    <th>Animal</th>
    <th>Adoptante</th> 
    <th>Fecha</th>
	<th>Estado</th>
	<th></th>
  </tr>
EOS;
if($solicitudes)foreach($solicitudes as $i){
$nombreAnimal=$i->getNombreAnimal();
$nombreUsuario=$i->getNombreUsuario();
$fecha=$i->getFecha();
$estado=$i->getEstado();
$enlace='<a href = "solicitud.php?idAni='.$i->getID().'&idUsu='.$i->getID_usuario().'"> Ver </a>';
$tablaSolicitudes .= <<<EOS
  <tr>
    <td>$nombreAnimal</td>
    <td>$nombreUsuario</td>
    <td>$fecha</td>
	<td>$estado</td>
	<td>$enlace</td>
  </tr>

EOS;
	
}
$tablaSolicitudes.="</table>";


$protectoras = es\ucm\fdi\aw\Protectora:: getProtectoras();
$tablaProtectoras= <<<EOS
<table>
  <tr>
    <th>ID</th>
    <th>Nombre</th> 
    <th>Direccion</th>
	<th>Telefono</th>
	<th></th>
  </tr>
EOS;
if($protectoras)foreach($protectoras as $i){
	$nombreProtectora=$i->getNombre();
	$id_protectora=$i->getID();
	$direccion=$i->getDireccion();
	$tlf=$i->getTelefono();
	$enlace='<a href = "protectora.php?id='.$i->getID().'"> Ver </a>';
	$tablaProtectoras .= <<<EOS
	  <tr>
		<td>$id_protectora</td>
		<td>$nombreProtectora</td>
		<td>$direccion</td>
		<td>$tlf</td>
		<td>$enlace</td>
	  </tr>
EOS;
}
$tablaProtectoras.="</table>";


$animales = es\ucm\fdi\aw\Animal:: getAnimales();
$tablaAnimales= <<<EOS
<table>
  <tr>
    <th>ID</th>
    <th>Nombre</th> 
    <th>Nacimiento</th>
	<th>Tipo</th>
	<th>Raza</th>
	<th>Sexo</th>
	<th>Peso</th>
	<th>Ingreso</th>
	<th>Urgente</th>
	<th>Adoptado</th>
  </tr>
EOS;
if($animales)foreach($animales as $i){
	$id_animal=$i->getID();
	$nombreAnimal=$i->getNombre();
	$nacimiento=$i->getNacimiento();
	$tipo=$i->getTipo();
	$raza=$i->getRaza();
	$sexo=$i->getSexo();
	$peso=$i->getPeso();
	$ingreso=$i->getFecha_ingreso();
	$urgente=$i->getUrgente()!=0 ? "SI":"NO";
	$adoptado=$i->getID_propietario()==null ? "NO": "SI";
	$enlace="<a href='perfil_animal.php?id=$id_animal'> Ver </a>";
	$tablaAnimales .= <<<EOS
	  <tr>
		<td>$id_animal</td>
		<td>$nombreAnimal</td>
		<td>$nacimiento</td>
		<td>$tipo</td>
		<td>$raza</td>
		<td>$sexo</td>
		<td>$peso</td>
		<td>$ingreso</td>
		<td>$urgente</td>
		<td>$adoptado</td>
		<td>$enlace</td>
	  </tr>
EOS;
}
$tablaAnimales.="</table>";

$usuarios = es\ucm\fdi\aw\Usuario:: getUsuarios();
$tablaUsuarios= <<<EOS
<table>
  <tr>
    <th>ID</th>
    <th>DNI</th> 
    <th>Nombre</th>
	<th>Apellido</th>
	<th>Telefono</th>
	<th>E-Mail</th>
	<th>Nacimiento</th>
	<th>Direccion</th>
	<th>Registro</th>
	<th>Rol</th>
  </tr>
EOS;
if($usuarios)foreach($usuarios as $i){
	$id_usuario=$i->getID();
	$dni=$i->getDNI();
	$nombre=$i->getNombre();
	$apellido=$i->getApellido();
	$telefono=$i->getTelefono();
	$email=$i->getEmail();
	$nacimiento=$i->getNacimiento();
	$direccion=$i->getDireccion();
	$registro=$i->getCreacion();
	$rol=$i->getTipo();
	$enlace="<a href='perfil_user.php?id=$id_usuario'> Ver </a>";
	$tablaUsuarios .= <<<EOS
	  <tr>
		<td>$id_usuario</td>
		<td>$dni</td>
		<td>$nombre</td>
		<td>$apellido</td>
		<td>$telefono</td>
		<td>$email</td>
		<td>$nacimiento</td>
		<td>$direccion</td>
		<td>$registro</td>
		<td>$rol</td>
		<td>$enlace</td>
	  </tr>
EOS;
}
$tablaUsuarios.="</table>";




$transacciones = es\ucm\fdi\aw\Transaccion:: getTransacciones();
$tablaTransacciones= <<<EOS
<table>
  <tr>
    <th>ID</th>
    <th>ID_usuario</th> 
    <th>cantidad</th>
	<th>tarjeta</th>
	<th>ID_animal</th>
	<th>fecha</th>
  </tr>
EOS;
if($transacciones)foreach($transacciones as $i){
	$ID=$i->getID();
	$ID_usuario=$i->getID_usuario();
	$cantidad=$i->getCantidad();
	$tarjeta=$i->getNumTarjeta();
	$ID_animal=$i->getID_animal();
	$fecha=$i->getFecha();
	
	if(empty($ID_animal)){
		$ID_animal = "null";
	}
	
	$tablaTransacciones .= <<<EOS
	  <tr>
		<td>$ID</td>
		<td>$ID_usuario</td>
		<td>$cantidad</td>
		<td>$tarjeta</td>
		<td>$ID_animal</td>
		<th>$fecha</th>
	  </tr>
EOS;
}
$tablaTransacciones.="</table>";



$comentarios = es\ucm\fdi\aw\Colabora:: getComentarios();
$tablaComentarios= <<<EOS
<table>
  <tr>
    <th>ID</th>
    <th>ID_usuario</th> 
    <th>comentario</th>
  </tr>
EOS;
if($comentarios)foreach($comentarios as $i){
	$ID=$i->getID_usuario();
	$ID_usuario=$i->getTipo();
	$comentario=$i->getID();
	
	$tablaComentarios .= <<<EOS
	  <tr>
		<td>$ID</td>
		<td>$ID_usuario</td>
		<td>$comentario</td>
	  </tr>
EOS;
}
$tablaComentarios.="</table>";


$form = new es\ucm\fdi\aw\FormularioRecaudar("1");
$htmlFormRecaudar = $form->gestiona();


$tituloPagina = 'Panel de control';

$contenidoPrincipal = <<<EOS
	<h1 class="titulo">Solicitudes</h1>
	$tablaSolicitudes
	
	<h1 class="titulo">Protectoras</h1>
	$tablaProtectoras

	<form action="addProtectora.php">
		<input type="submit" value="Añadir protectora" />
	</form>

	<h1 class="titulo">Animales</h1>
	$tablaAnimales
	<form action="addAnimal.php">
		<input type="submit" value="Añadir animal" />
	</form>
	
	<h1 class="titulo">Usuarios</h1>
	$tablaUsuarios
	
	<h1 class="titulo">Transacciones</h1>
	$tablaTransacciones
	
	<h1 class="titulo">Comentarios/Voluntariados</h1>
	$tablaComentarios
	
	<h1 class="titulo">Recaudacion de los apadrinamientos</h1>
	$htmlFormRecaudar
EOS;
}
else{
$contenidoPrincipal = <<<EOS
	<h1>No tienes permiso para estar aquí...</h1>
EOS;
}
require __DIR__.'/includes/plantillas/plantilla.php';
