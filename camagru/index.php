<?php
	session_start();
  if (isset($_SESSION['message'])) {
    if (isset($_SESSION['message']['success'])){
      $class_name = 'success';
    }
    else {
      $class_name = 'error';
    }
    require_once('views/flash_message.php');
  }
  if (!isset($_SESSION['login'])) {
	require_once('views/partials/header.php');
?>
<link rel="stylesheet" type="text/css" href="/assets/css/home.css">
<div class="camagru_container">
		<h1 class="camagru-title">_Camagru </h1>
		<div class="auth-container">
			<img src="/assets/images/camera_128.png"/>
			<form class="login-form" action = "servers/authentification.php" method = "post">
					<div class="login-group">
			    	<label for="username">login :</label> <br>
			    	<input type = "text" name = "login" required />
			    </div>
			    <div class="password-group">
					<label for="username">Mot de passe : </label> <br>
			    	<input type = "password" name = "password" required />
			    </div>
			    <button type = "submit">Valider</button> <br>
					<a class="password-recovery" href="/views/recovery.php">Mot de passe oublié ?</a> <br>
			    <a class="inscription" href="/views/register.php">Nouveau sur _Camagru ?</a>
			</form>
		</div>
</div>
<?php
  require_once('views/partials/footer.php');
}else {
	header('Location: /views/snapshots.php');
	exit;
}
?>
