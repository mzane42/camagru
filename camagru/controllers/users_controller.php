<?php

class usersController {

	public function create($confirm) {
			if (isset($confirm)){
				try {
					$confirm_user = User::confirmed($_GET['confirm']);
				}
				catch(exception $e) {
					$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
					header('Location: /views/pages/error.php');
					exit;
				}
				$_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Vous pouvez maintenant vous connectez.";
				header('Location: /');
				exit;
			}
			if (isset($_POST['login'])) {
				$login	= UsersController::test_input($_POST['login']);
				$password	= UsersController::test_input(hash('whirlpool', $_POST['password']."camagru"));
				$email =  UsersController::test_input($_POST['email']);
				$validation = User::validation($login, $email);
				if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,40}$/', $_POST['password'])) {
					$_SESSION["message"]["error"] = "<strong>Attention !</strong> the password does not meet the requirements! <br> Tips: <br> en moins un number <br> en moins un letter <br>  La taile du mot de passe doit etre entre 8 et 40  ";
					header('Location: /views/register.php');
					exit;
				}
				if (isset($validation->id)) {
					$_SESSION["message"]["error"] = "<strong>Attention !</strong> Le login et/ou l'adresse e-mail existe déjà.";
					header('Location: /views/register.php');
					exit;
				}
				$headers = 'From: Admin<camagru.project@gmail.com>' . "\r\n" .
					'Reply-To: <camagru.project@gmail.com>' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$random_confirmed = "";
				for ($i=0; $i <= strlen($salt)/2; $i++){
					$random_confirmed .= $salt[rand() % strlen($salt)];
				}
				$confirm = htmlspecialchars(hash('md5', $random_confirmed.$email));
				$link = "http://localhost:8080/servers/confirm.php?confirm=".$confirm;
				$msg = "Please click on the below link to active your password : \n" . $link;
				mail($email, "Active your account", $msg, $headers);
				 try {
				$new_user = User::new($login, $email, $password, $confirm);
				}
				catch (exception $e){
				 		$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
						header('Location: /views/pages/error.php');
						exit;
				}
        $_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Rendez-vous dans votre boite e-mail pour confirmer votre inscription.";
				header('Location: /');
				exit;
			}
			else {
				header('Location: /views/register.php');
				exit;
			}
	}

	public function login() {
		// if (isset($_SESSION['login'])){
		// 	unset($_SESSION['login']);
		// }
		if (isset($_POST['login'])){
			$login	= UsersController::test_input($_POST['login']);
			$password	= UsersController::test_input(hash('whirlpool', $_POST['password']."camagru"));
			try {
			$auth = User::authentification($login, $password);
			}
			catch (exception $e){
				header('Location: /views/pages/error.php');
				exit;
			}
			if ($auth->password == $password){
				$_SESSION['login'] = $login;
				header('Location: /views/snapshots.php');
				exit;
			}
			else{
				$_SESSION['message']['error'] = "<strong> Attention ! </strong> Login et/ou mot de passe incorrect";
				header('Location: /');
				exit;
			}
		}
	}

	public function recover(){
		if (isset($_GET['reset'])){
			$reset = $_GET['reset'];
			require_once('views/users/new_password.php');
		}
		else{
			require_once('views/users/recover.php');
		}
	}

	public function reset() {
		if (!isset($_SESSION['login'])){
			if (isset($_POST['reset'])){
				$password	= UsersController::test_input(hash('whirlpool', $_POST['password']."camagru"));
				$reset = $_POST['reset'];
				$reset_confirmed = User::reset_confirmed($password, $reset);
				$_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Vous pouvez maintenant vous connectez.";
			}
			else {
				$email = UsersController::test_input($_POST['email']);
				$validation = User::validation_email($email);
				if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,40}$/', $_POST['password'])) {
					$_SESSION["message"]["error"] = "<strong>Attention !</strong> the password does not meet the requirements! <br> Tips: <br> en moins un number <br> en moins un letter <br>  La taile du mot de passe doit etre entre 8 et 40  ";
					header('Location: views/recovery.php');
					exit;
				}
				if (!isset($validation->id)) {
					$_SESSION["message"]["error"] = "<strong>Attention !</strong> l'adresse e-mail n'existe pas.";
					header('Location: views/recovery.php');
					exit;
				}
				$headers = 'From: Admin<camagru.project@gmail.com>' . "\r\n" .
					'Reply-To: <camagru.project@gmail.com>' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$random_reset = "";
				for ($i=0; $i <= strlen($salt)/2; $i++){
					$random_reset .= $salt[rand() % strlen($salt)];
				}
				$reset = htmlspecialchars(hash('md5', $random_reset.$email));
				$link = "http://localhost:8080/views/recovery.php?reset=".$reset;
				$msg = "Please click on the below link to reset your password : \n" . $link;
				mail($email, "Reset Password", $msg, $headers);
				$reset = User::reset($email, $reset);
				$_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Rendez-vous dans votre boite e-mail pour la suite.";
			}
			header('Location: /');
			exit;
		}
		else {
			header('Location: /');
			exit;
		}
	}


	private	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
}

?>
