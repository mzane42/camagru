<?php
  require_once 'config/database.php';
  require_once 'routes.php';
  require_once 'models/user.php';
  require_once 'models/image.php';

  class commentsController {
    public function create() {
      $user = User::find($_SESSION['login']);
      $user_id = $user->id;
      $content	= commentsController::test_input($_POST['content']);
      $image_id = $_POST['image_id'];
      $creator = Image::find_creator($image_id);

      $headers = 'From: Admin<admin@camagru.42.fr>' . "\r\n" .
    		'Reply-To: <admin@camagru.42.fr>' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();
    	$msg = "'$user->login' commented on one of your photos.\n\n'$user->login' : '$content'";
    	mail($creator->email, "New Comment", $msg, $headers);
      try {
         $new_comment = Comment::create_comment($content, $image_id, $user_id);
       }
      catch (exception $e){
          $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
          call('pages', "error");
          exit;
      }
      call('images','index');
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
