<?php
if( !session_id() )
  {
      session_start();
  }
require_once('../connection.php');
require_once('../controllers/images_controller.php');
require_once('../models/image.php');
$controller = new imagesController();
$controller->delete_image();

?>
