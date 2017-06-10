<?php
	if( !session_id() )
	{
	    session_start();
	}
?>
<!DOCTYPE HTML5>
<html>
	<head>
	<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="assets/images/camera.png" />
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/camagru.css" media="all"/>
		<link href='https://fonts.googleapis.com/css?family=Averia+Sans+Libre' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<nav class="header-container">
			<div class="header">
				<a href="?controller=pages&action=home"> <img class="header-logo" src="assets/images/camera.png"/> </a>
				<div class="menu-wrapper">
					<ul class="menu">
					  <li class="menu-row"><a class="log active" href="?controller=pages&action=home">_Accueil</a></li>
						<?php if (isset($_SESSION['login'])){ ?>
								<li class="menu-row"><a class="log" href="?controller=images&action=index">_Gallerie</a></li>
								<li class="menu-row"><a class="log" href="?controller=users&action=logout">_Déconnexion</a></li>
						<?php } else{ ?>
								<li class="menu-row"><a class="log" href="?controller=pages&action=home">_Connexion</a></li>
								<li class="menu-row"><a class="log" href="?controller=users&action='new'">_Inscription</a></li>
							<?php }?>
					</ul>
				</div>
			</div>
		</nav>
	    <?php require_once('routes.php'); ?>
		<script src="/assets/js/camagru.js"></script>
		<footer> mzane42 </footer>
	</body>
</html>
