<?php
	if( !session_id() )
	{
	    session_start();
	}
?>
<link rel="stylesheet" type="text/css" href="/assets/css/flash.css">
<div class="flash-container">
  <div class="flash-message <?php echo $class_name; ?>">
    <?php
			if (isset($_SESSION["message"]["error"])){
				echo $_SESSION["message"]["error"];
				session_unset($_SESSION["message"]["error"]);
			} else {
				echo $_SESSION["message"]["success"];
				session_unset($_SESSION["message"]["success"]);
			}
    ?>
  </div>
</div>
