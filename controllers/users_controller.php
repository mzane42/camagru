<?php
require_once 'config/database.php';
require_once 'routes.php';
require_once 'flash.php';

class usersController {
	public function new() {
		require_once('views/users/new.php');
	}

	public function create() {
			if( !session_id() )
		    {
		        session_start();
		    }

			if (isset($_GET['confirm'])){
				try {
					$confirm_user = User::confirmed($_GET['confirm']);
				}
				catch(exception $e) {
					$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
				 	call('pages', "error");
					exit;
				}
				$_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Vous pouvez maintenant vous connectez.";
				call('pages', 'home');
				exit;
			}
			if (isset($_POST['login'])) {
				$login	= UsersController::test_input($_POST['login']);
				$password	= UsersController::test_input(hash('whirlpool', $_POST['password']."camagru"));
				$email =  UsersController::test_input($_POST['email']);
				$validation = User::validation($login, $email);
				if (isset($validation->id)) {
					$_SESSION["message"]["error"] = "<strong>Attention !</strong> Le login et/ou l'adresse e-mail existe déjà.";
					call('users', 'new');
					exit;
				}
				$headers = 'From: Admin<admin@camagru.42.fr>' . "\r\n" .
					'Reply-To: <admin@camagru.42.fr>' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$random_confirmed = "";
				for ($i=0; $i <= strlen($salt)/2; $i++){
					$random_confirmed .= $salt[rand() % strlen($salt)];
				}
				$confirm = htmlspecialchars(hash('md5', $random_confirmed.$email));
				$link = "http://localhost:8080/index.php?controller=users&action=create&confirm=".$confirm;
				$msg = "Please click on the below link to active your password : \n" . $link;
				mail($email, "Active your account", $msg, $headers);
				 try {
				$new_user = User::new($login, $email, $password, $confirm);
				}
				catch (exception $e){
				 		$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
						call('pages', "error");
						exit;
				}
        $_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Rendez-vous dans votre boite e-mail pour confirmer votre inscription.";
				call('pages', 'home');
				exit;
			}
			else {
				call('users', 'new');
				exit;
			}
	}

	public function login() {
		if( !session_id() )
		{
					session_start();
		}
		if (isset($_SESSION['login'])){
			unset($_SESSION['login']);
		}
		if (isset($_POST['login'])){
			$login	= UsersController::test_input($_POST['login']);
			$password	= UsersController::test_input(hash('whirlpool', $_POST['password']."camagru"));
			try {
			$auth = User::authentification($login, $password);
			}
			catch (exception $e){
			call('pages','error');
				exit;
			}
			if ($auth->password == $password){
				$_SESSION['login'] = $login;
				call('images', 'new');
				exit;
			}
			else{
				$_SESSION['message']['error'] = "<strong> Attention ! </strong> Login et/ou mot de passe incorrect";
				call('pages', 'home');
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
		session_start();
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
				if (!isset($validation->id)) {
					$_SESSION["message"]["error"] = "<strong>Attention !</strong> l'adresse e-mail n'existe pas.";
					call('users', 'recover');
					exit;
				}
				$headers = 'From: Admin<admin@camagru.42.fr>' . "\r\n" .
					'Reply-To: <admin@camagru.42.fr>' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$random_reset = "";
				for ($i=0; $i <= strlen($salt)/2; $i++){
					$random_reset .= $salt[rand() % strlen($salt)];
				}
				$reset = htmlspecialchars(hash('md5', $random_reset.$email));
				$link = "http://localhost:8080/index.php?controller=users&action=recover&reset=".$reset;
				$msg = "Please click on the below link to reset your password : \n" . $link;
				mail($email, "Reset Password", $msg, $headers);
				$reset = User::reset($email, $reset);
				$_SESSION['message']["success"] = "<strong> Felicitation ! </strong>  Rendez-vous dans votre boite e-mail pour la suite.";
			}
			call('pages', 'home');
			exit;
		}
		else {
			call('pages', 'home');
			exit;
		}
	}

	public function logout() {
		session_start();
		session_unset($_SESSION['login']);
		call('pages', 'home');
		exit;
	}

	private	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
}

?>
