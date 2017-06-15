<?php
 	if( !session_id() )
    {
        session_start();
    }
	require_once('../partials/header.php');
  require_once('../../controllers/pages_controller.php');
  $controller = new pagesController();
  if (isset($_SESSION['message'])) {
    $class_name = 'error';
    require_once('views/flash_message.php');
  }
?>
<link rel="stylesheet" type="text/css" href="/assets/css/error.css">
<div class="camagru-error-container">
	<h1 class="camagru-title"> _Camagru erreur</h1>
	<img src="/assets/images/error_camagru.png"/>
	<h2> Outch... !!! </h2>
</div>
<?php
	require_once('../partials/footer.php');
?>
