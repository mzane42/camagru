<link rel="stylesheet" type="text/css" href="/assets/css/register.css">
<div class="camagru-register-container">
	<h1 class="camagru-title"> _Camagru </h1>
	<h2> _Nouveau Mot de passe ?</h2>
	<img class="form-image" src="assets/images/key.png" />
  <p class="recover-label"> Choisissez un nouveau mot de passe : </p>
  <form action="index.php" name="reset_confirm" method="post" accept-charset="utf-8">
  		<input name="controller" value="users" hidden />
  		<input name="action" value="reset" hidden/>
      <input name="reset" value="<?php echo $_GET['reset']; ?>" hidden />
      <div class="form-group">
        <label class="form-label" for="password"> Ton mot de passe : </label>
        <!-- <input class="form-input" id="password" type="password" name="password" required> !-->
        <input pattern=".{6,}" required title="le mot de passe doit contenir au moins 6 caractères" class="form-input" id="password" type="password" name="password" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="confirm-pwd"> Confirme ton mot de passe : </label>
        <!-- <input class="form-input" id="confirm_password" type="password" name="confirm-pwd" required> !-->
        <input pattern=".{6,}" required title="le mot de passe doit contenir au moins 6 caractères" class="form-input" id="confirm_password" type="password" name="confirm-pwd" required>
      </div>
		<button class="form-button" type="submit">Nouveau mot de passe</button>
	</form>
</div>
