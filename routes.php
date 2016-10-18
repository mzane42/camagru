<?php
 	if( !session_id() )
    {
        session_start();
    }
	function call ($controller, $action) {
    require_once('controllers/'. $controller .'_controller.php');
		//create the new instance for the controller needed
		switch($controller){
			case 'pages':
				$controller = new pagesController();
			break;
			case 'images':
				require_once('models/image.php');
				$controller = new imagesController();
			break;
			case 'users':
				require_once('models/user.php');
				$controller = new usersController();
			break;
      case 'comments':
        require_once('models/comment.php');
        $controller = new commentsController();
      break;
      case 'likes':
        require_once('models/like.php');
        $controller = new likesController();
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
						 'users' => ['new', 'create', 'login', 'recover', 'reset', 'logout'],
             'comments' => ['create', 'comments_image']);

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
