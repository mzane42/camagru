<?php
	require_once 'config/database.php';

	class User {
		public $id;
		public $login;
		public $email;
		public $password;
		public $confirmed;
		public $confirm;
		public $reset;

		public function __construct($id, $login, $email, $password, $confirmed, $confirm, $reset){
			$this->id = $id;
			$this->login = $login;
			$this->email = $email;
			$this->password = $password;
			$this->confirmed = $confirmed;
			$this->confirm = $confirm;
			$this->reset = $reset;
		}

		public static function find($login){
			$pdo = Db::getInstance();
			$req = $pdo->prepare('SELECT * FROM user where login = :login');
			$req->execute(array('login' => $login));
			$user = $req->fetch();
			return new User($user['id'], $user['login'], $user['email'], $user['password'], $user['confirmed'], $user['confirm'], $user['reset']);
		}

		public static function new($login, $email, $password, $confirm) {
			$pdo = Db::getInstance();
			$stmt = $pdo->prepare("INSERT INTO user(login, email, password, confirm) VALUES(:login, :email, :password, :confirm)");
			$stmt->bindValue(':login', $login);
			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':password', $password);
			$stmt->bindValue(':confirm', $confirm);
			$stmt->execute();
		}
		public static function confirmed($confirm){
			$pdo = Db::getInstance();
			$stmt = $pdo->prepare("UPDATE user SET confirmed='1' WHERE confirm=:confirm");
			$stmt->bindValue(':confirm', $confirm);
			$stmt->execute();
			$stmt = $pdo->prepare("UPDATE user SET confirm=NULL WHERE confirm=:confirm");
			$stmt->bindValue(':confirm', $confirm);
			$stmt->execute();
		}

		public static function authentification($login, $password) {
			$pdo = Db::getInstance();
			$stmt = $pdo->prepare("SELECT * FROM user WHERE login=:login AND confirmed='1'");
			$stmt->bindValue(':login', $login, PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch();
			return new User($user['id'], $user['login'], $user['email'], $user['password'], $user['confirmed'], $user['confirm'], $user['reset']);
		}

		public static function reset($email, $reset){
			$pdo = Db::getInstance();
			$stmt = $pdo->prepare("UPDATE user SET reset=:reset where email=:email");
			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':reset', $reset);
			$stmt->execute();
		}
		public static function reset_confirmed($password, $reset){
			$pdo = Db::getInstance();
			var_dump($password);
			var_dump($reset);
			$stmt = $pdo->prepare("UPDATE user SET password=:password where reset=:reset");
			$stmt->bindValue(':password', $password);
			$stmt->bindValue(':reset', $reset);
			$stmt->execute();
			$stmt = $pdo->prepare("UPDATE user SET reset=NULL where reset=:reset");
			$stmt->bindValue(':reset', $reset);
			$stmt->execute();
		}
		public static function validation($login, $email){
			$pdo = Db::getInstance();
			$req = $pdo->prepare('SELECT * FROM user WHERE login = :login OR email = :email');
			$req->execute(array('login' => $login, 'email' => $email));
			$user = $req->fetch();

			return new User($user['id'], $user['login'], $user['email'], $user['password'], $user['confirmed'], $user['confirm'], $user['reset']);
		}

		public static function validation_email($email){
			$pdo = Db::getInstance();
			$req = $pdo->prepare('SELECT * FROM user WHERE email = :email');
			$req->execute(array('email' => $email));
			$user = $req->fetch();

			return new User($user['id'], $user['login'], $user['email'], $user['password'], $user['confirmed'], $user['confirm'], $user['reset']);
		}
	}
?>
