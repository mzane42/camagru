<?php
if( !session_id() )
  {
      session_start();
  }
require_once('../connection.php');
require_once('../controllers/users_controller.php');
require_once('../models/user.php');
$controller = new usersController();
$controller->login();

?>
