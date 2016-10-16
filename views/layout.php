<?php
require_once('controllers/flash.php');
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
					  <li class="menu-row"><a class="log active" href="#h">_Accueil</a></li>
					  <li class="menu-row"><a class="log" href="#">_Gallerie</a></li>
					  <li class="menu-row"><a class="log" href="#">_Connexion</a></li>
					  <li class="menu-row"><a class="log" href="#">_Inscription</a></li>
					</ul>
				</div>
			</div>
		</nav>
	    <?php require_once('routes.php'); ?>
		</div>
		<script src="/assets/js/camagru.js"></script>
		<footer> mzane42 </footer>
	</body>
</html>
