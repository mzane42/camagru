<?php
	class PagesController {

		public function home () {
			if ( !session_id() )
		    {
		        session_start();
		    }
			require_once('views/pages/home.php');
		}
		public function error () {
			require_once('views/pages/error.php');
		}

	}
?>
