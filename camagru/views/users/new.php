<link rel="stylesheet" type="text/css" href="/assets/css/register.css">
<div class="camagru-register-container">
	<h1 class="camagru-title"> _Camagru </h1>
	<h2> _Inscription  </h2>
	<img class="form-image" src="assets/images/hamster.png" />
	<form action="index.php" name="register" method="post" accept-charset="utf-8">
  		<input name="controller" value="users" hidden />
  		<input name="action" value="create" hidden/>
  		<div class="form-group">
  		  	<label class="form-label" for="login"> Ton Login : </label>
			<input pattern=".{3,}" required title="le login doit contenir au moins 3 caractères" class="form-input" id="login" type="text" name="login" required>
  		</div>
  		<div class="form-group">
  		  	<label class="form-label" for="email"> Ton email : </label>
			<input class="form-input" id="email" type="email" name="email" required>
  		</div>
		<div class="form-group">
		  	<label class="form-label" for="password"> Ton mot de passe : </label>
			<!-- <input class="form-input" id="password" type="password" name="password" required> !-->
			<input pattern=".{6,}" required title="le mot de passe doit contenir au moins 6 caractères" class="form-input" id="password" type="password" name="password" required>
  		</div>
		<div class="form-group">
			<label class="form-label" for="confirm-pwd"> Confirme ton mot de passe : </label>
			<input pattern=".{6,}" required title="le mot de passe doit contenir au moins 6 caractères" class="form-input" id="confirm_password" type="password" name="confirm-pwd" required>
			<!-- <input class="form-input" id="confirm_password" type="password" name="confirm-pwd" required> !-->
  		</div>
		<button class="form-button" type="submit">S'inscrire</button>
	</form>
</div>
<script src="/assets/js/register.js"></script>
