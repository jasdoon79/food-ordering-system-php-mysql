<?php
	//Start Session
	ini_set('session.use_only_cookies', 1);
	session_name("VendorSession");
	session_start();

	//Unset variables of session
	session_unset();

	//Destroy Session
	session_destroy();
	
	header('Location: index');
	exit();
?>