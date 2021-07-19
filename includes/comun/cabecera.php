<header>
	<div class="header">
	
	
		<a href="index.php" id="header"><img class="logoWeb" src="img/Logo.jpg" alt="Foto Logo"></a>
		<?php
		require_once ("includes/config.php");
		require_once ("includes/usuarioUtils.php");
		
		$gatosEnAdopcion = es\ucm\fdi\aw\Animal:: getGatosEnAdopcion();
		$numGatos = count($gatosEnAdopcion);
		$gatosAdop = es\ucm\fdi\aw\Animal:: getGatosAdoptados();
		$numGatosAdop = count($gatosAdop);
		$perrosEnAdopcion = es\ucm\fdi\aw\Animal:: getPerrosEnAdopcion();
		$numPerros = count($perrosEnAdopcion);
		$perrosAdoptados = es\ucm\fdi\aw\Animal:: getPerrosAdopdatos();
		$numPerrosAdop = count($perrosAdoptados);
		
		?>

		<p>Gatos en adopcion: <?php  printf($numGatos); ?> |
		Gatos adoptados: <?php  printf($numGatosAdop); ?> |
		Perros en adopción: <?php  printf($numPerros); ?> |
		Perros adoptados: <?php  printf($numPerrosAdop); ?>
		</p>
		
		<?php
		if (isset($_SESSION["login"])&& (($_SESSION["tipo"])=='voluntario' || ($_SESSION["tipo"])=='administrador')){
			echo "<h4><a href=controlPanel.php> Panel de control </a></h4>";
		}
		?>
		
		<?php 
		if(isset($_SESSION["login"]) && $_SESSION ["login"] == true){
			echo(htmlspecialchars(trim(strip_tags($_SESSION["nombre"]))));
		}
		?>		


		<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="css/cabecera.css">
</head>

<body>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="imgBx">
                    <img src="img/img1.jpg" alt="">
                </div>
                <div class="details">
                        <span><a href=animalesAdopcion.php>| Animales en adopción |</a></span>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="imgBx">
                    <img src="img/img2.jpg" alt="">
                </div>
                <div class="details">
					<span><a href=protectoras.php>| Protectoras |</a></span>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="imgBx">
                    <img src="img/img3.jpg" alt="">
                </div>
                <div class="details">
						<span><a href=historiasFelices.php>| Historias felices |</a></span>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="imgBx">
                    <img src="img/img4.jpg" alt="">
                </div>
                <div class="details">
                        <span><a href=colabora.php>| Colabora con nosotros |</a></span>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="imgBx">
                    <img src="img/img5.jpg" alt="">
                </div>
                <div class="details">
                        <span><a href=foro.php>| Foro |</a></span>
                </div>
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <!-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div> -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/js/swiper.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            // autoplay: {
            //     delay: 2000,
            //     disableOnInteraction: false,
            // },
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 30,
                stretch: 10,
                depth: 200,
                modifier: 1,
                slideShadows: true,
            },
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                // type: 'fraction',
                clickable: true,
            },
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // },
        });
    </script>
</body>

		
	</div>
	
	<div class="saludo">

		<?php
			if (isset($_SESSION["DNI"])){
				echo '<a href="perfil_user.php">Perfil</a> | ';
				echo '<a href="logout.php">Cerrar sesión</a>';
			}
			else{
				echo '<a href="login.php">Iniciar sesión</a> | ';
				echo '<a href="register.php">Registrarse</a>';
			}
		?>
	</div>
		
	
</header>

