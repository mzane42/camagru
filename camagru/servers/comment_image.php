<?php
if( !session_id() )
  {
      session_start();
  }
require_once('../connection.php');
require_once('../controllers/comments_controller.php');
require_once('../models/comment.php');
$controller = new commentsController();
$controller->create();

?>
