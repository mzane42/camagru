<?php
if( !session_id() )
  {
      session_start();
  }
require_once('../connection.php');
require_once('../controllers/likes_controller.php');
require_once('../models/like.php');
$controller = new likesController();
$controller->like();

?>
