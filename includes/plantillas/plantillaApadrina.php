<!DOCTYPE html>

<html>
 <head>
	<link rel="stylesheet" type="text/css" href="css/stylus.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?= $tituloPagina ?></title>
 </head>
 
 <body>
	
	<main>
		<article>
 
		<?= $contenidoPrincipal ?>
		
		</article>
	</main>
	 
	 <?php
		require("includes/comun/pie.php");
	?>

 </body>
 
</html>
