<?php
if( !session_id() ) {
			session_start();
	}
	require_once('../connection.php');
  require_once('partials/header.php');
  require_once('../controllers/users_controller.php');
  require_once('../models/user.php');
  $controller = new usersController();
  if (isset($_SESSION['message'])) {
    if (isset($_SESSION['message']['success'])){
      $class_name = 'success';
    }
    else {
      $class_name = 'error';
    }
    require_once('flash_message.php');
  }
if (isset($_GET['reset'])){
  $reset = $_GET['reset']; ?>
  <link rel="stylesheet" type="text/css" href="/assets/css/register.css">
  <div class="camagru-register-container">
  	<h1 class="camagru-title"> _Camagru </h1>
  	<h2> _Nouveau Mot de passe ?</h2>
  	<img class="form-image" src="/assets/images/key.png" />
    <p class="recover-label"> Choisissez un nouveau mot de passe : </p>
    <form action="/servers/recovery.php" name="reset_confirm" method="post" accept-charset="utf-8">
        <input name="reset" value="<?php echo $_GET['reset']; ?>" hidden />
        <div class="form-group">
          <label class="form-label" for="password"> Ton mot de passe : </label>
          <input pattern=".{6,}" required title="le mot de passe doit contenir au moins 6 caractères" class="form-input" id="password" type="password" name="password" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="confirm-pwd"> Confirme ton mot de passe : </label>
          <input pattern=".{6,}" required title="le mot de passe doit contenir au moins 6 caractères" class="form-input" id="confirm_password" type="password" name="confirm-pwd" required>
        </div>
  		<button class="form-button" type="submit">Nouveau mot de passe</button>
  	</form>
  </div>
<?php
}
else{ ?>
  <link rel="stylesheet" type="text/css" href="/assets/css/register.css">
  <div class="camagru-register-container">
  	<h1 class="camagru-title"> _Camagru </h1>
  	<h2> _Mot de passe oublié ?</h2>
  	<img class="form-image" src="/assets/images/key.png" />
    <p class="recover-label"> Une fois l'email validé, rendez-vous sur votre boite mail. </p>
  	<form action="/servers/recovery.php" name="reset" method="post" accept-charset="utf-8">
    		<div class="form-group">
    		  	<label class="form-label recover" for="email"> Ton email : </label>
            <input class="form-input" id="email" type="email" name="email" required>
    		</div>
  		<button class="form-button" type="submit">Envoyé</button>
  	</form>
  </div>
<?php
}
require_once('partials/footer.php');

?>
