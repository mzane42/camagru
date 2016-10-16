<link rel="stylesheet" type="text/css" href="/assets/css/home.css">
<div class="camagru_container">
		<h1 class="camagru-title">Bienvenue sur _Camagru </h1>
		<div class="auth-container">
			<img src="/assets/images/camera_128.png"/>
			<form class="login-form" action = "index.php" method = "post">
					<input name="controller" value="users" hidden />
					<input name="action" value="login" hidden/>
					<div class="login-group">
			    	<label for="username">login :</label> <br>
			    	<input type = "text" name = "login" required />
			    </div>
			    <div class="password-group">
					<label for="username">Mot de passe : </label> <br>
			    	<input type = "password" name = "password" required />
			    </div>
			    <button type = "submit">Valider</button> <br>
			    <a class="password-recovery" href="?controller=users&action=recover">Mot de passe oublié ?</a> <br>
			    <a class="inscription" href="?controller=users&action=new">Nouveau sur _Camagru ?</a>
			</form>
		</div>
</div>
