<?php
	if( !session_id() )
	{
	    session_start();
	}

	class FlashMessage
	{

	    static public function create($name, $value)
	    {
	        if(!isset($_SESSION['message'][$name])) {
	            $_SESSION['message'][$name] = $value;
	        }

	    }

	    static public function read($name)
	    {
	        if(isset($_SESSION['message'][$name])) {
	            $message = $_SESSION['message'][$name];
	            unset($_SESSION['message'][$name]);
	            return $message;
	        }
			return false;
	    }
	}


?>