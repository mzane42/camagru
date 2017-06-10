<link rel="stylesheet" type="text/css" href="/assets/css/register.css">
<div class="camagru-register-container">
	<h1 class="camagru-title"> _Camagru </h1>
	<h2> _Mot de passe oublié ?</h2>
	<img class="form-image" src="assets/images/key.png" />
  <p class="recover-label"> Une fois l'email validé, rendez-vous sur votre boite mail. </p>
	<form action="index.php" name="reset" method="post" accept-charset="utf-8">
  		<input name="controller" value="users" hidden />
  		<input name="action" value="reset" hidden/>
  		<div class="form-group">
  		  	<label class="form-label recover" for="email"> Ton email : </label>
          <input class="form-input" id="email" type="email" name="email" required>
  		</div>
		<button class="form-button" type="submit">Envoyé</button>
	</form>
</div>
