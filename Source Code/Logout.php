<?PHP
	session_start();
	session_unset();
	session_destroy();
	echo '<script>window.location = "Login.php";</script>';
?>