<?php
 	if( !session_id() )
    {
        session_start();
    }
	require_once('connection.php');
	if (isset($_GET['controller']) && isset($_GET['action'])){
		$controller = $_GET['controller'];
		$action = $_GET['action'];
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $controller = $_POST['controller'];
		$action = $_POST['action'];
    var_dump($controller);
    var_dump($action);
	}
	else{
		$controller = 'pages';
		$action = 'home';
	}
	if (isset($_SESSION["message"])) {
		if (isset($_SESSION["message"]["success"])){
			$flash = $_SESSION["message"]['success'];
		}
		elseif (isset($_SESSION["message"]["error"])) {
			$flash = $_SESSION["message"]['error'];
		}
		else {
			$flash = "";
		}
	}
	else {
		$flash = "";
	}
	require_once('views/layout.php');
?>
