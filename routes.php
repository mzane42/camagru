<?php
 	if( !session_id() )
    {
        session_start();
    }
	function call ($controller, $action) {
		//require the file that matches with the controller name
		require_once('controllers/'. $controller .'_controller.php');
		//create the new instance for the controller needed
		switch($controller){
			case 'pages':
				$controller = new PagesController();
			break;
			case 'images':
				require_once('models/image.php');
				$controller = new ImagesController();
			break;
			case 'users':
				require_once('models/user.php');
				$controller = new UsersController();
			break;
		}
    if (isset($_SESSION['message'])) {
      if (isset($_SESSION['message']['success'])){
        $class_name = 'success';
      }
      else {
        $class_name = 'error';
      }
      require_once('views/flash_message.php');
    }
		$controller->{ $action }();
	}
	$controllers = array('pages' => ['home', 'error'],
						 'images' => ['index', 'new', 'create'],
						 'users' => ['new', 'create', 'login', 'recover', 'reset']);

	if (array_key_exists($controller, $controllers)){
		if (in_array($action, $controllers[$controller])){
			call($controller, $action);
		}
		else {
			call('pages', 'error');
		}
	}
	else {
		call('pages', 'error');
	}
?>
