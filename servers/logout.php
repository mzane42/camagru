<?php
if( !session_id() )
  {
      session_start();
  }
  session_unset($_SESSION['login']);
  header('location : /');
  exit;
?>
