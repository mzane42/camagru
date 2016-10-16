<?php
	require_once('config/database.php');
	
	class Db {
	private static $instance = NULL;
	private function __construct() {}
	private function _clone() {}
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			try {
				self::$instance = new PDO("mysql:host=localhost;dbname=db_camagru;", $DB_USER, $DB_PASSWORD, $pdo_options);
			}
			catch(PDOException $e) {
				$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
				die($msg);
			}
		}
		return self::$instance;
		}
	}
?>