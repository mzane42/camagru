<!DOCTYPE HTML5>
<html>
	<head>
	<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="assets/images/camera.png" />
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/camagru.css" media="all"/>
		<link href='https://fonts.googleapis.com/css?family=Averia+Sans+Libre' rel='stylesheet' type='text/css'>
	</head>
	<body style="margin: 0;">
		<nav class="header-container">
			<div class="header">
				<a href="/"> <img class="header-logo" src="/assets/images/camera.png"/> </a>
				<div class="menu-wrapper">
					<ul class="menu">
								<li class="menu-row"><a class="log active" href="/">_Accueil</a></li>
								<li class="menu-row"><a class="log" href="/views/gallery.php">_Gallerie</a></li>
						<?php if (isset($_SESSION['login'])){?>
								<li class="menu-row"><a class="log" href="/servers/logout.php">_Déconnexion</a></li>
						<?php } else{ ?>
								<li class="menu-row"><a class="log" href="/">_Connexion</a></li>
								<li class="menu-row"><a class="log" href="/views/register.php">_Inscription</a></li>
						<?php }?>
					</ul>
				</div>
			</div>
		</nav>
